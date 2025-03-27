<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\ImageView;
use App\Models\Settings;
use App\Models\AccessToken;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['display']);
    }

    // Display All Posts
    public function add(Request $request)
    {
        $search = $request->input('search');
        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');

        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $posts = Image::select("id", "title", "links", "slug", "views", "created_at")
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);

        // Stats
        $totalPosts = Image::count();
        $totalViews = Image::sum('views');
        
        // Calculate growth percentages
        $now = now();
        $currentMonth = $now->format('m');
        $currentYear = $now->format('Y');
        $lastMonth = $now->subMonth()->format('m');
        $lastMonthYear = $now->format('Y');
        
        // Posts growth
        $currentMonthPosts = Image::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
            
        $lastMonthPosts = Image::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
            
        $postsGrowth = 0;
        if ($lastMonthPosts > 0) {
            $postsGrowth = round((($currentMonthPosts - $lastMonthPosts) / $lastMonthPosts) * 100);
        } elseif ($currentMonthPosts > 0) {
            $postsGrowth = 100; // If there were no posts last month but there are this month
        }
        
        // Views growth (based on views added this month vs last month)
        $currentMonthViews = ImageView::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
            
        $lastMonthViews = ImageView::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
            
        $viewsGrowth = 0;
        if ($lastMonthViews > 0) {
            $viewsGrowth = round((($currentMonthViews - $lastMonthViews) / $lastMonthViews) * 100);
        } elseif ($currentMonthViews > 0) {
            $viewsGrowth = 100; // If there were no views last month but there are this month
        }
        
        $userName = \Illuminate\Support\Facades\Auth::user()->name;
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        return view('nsfw.image.add', compact(
            'posts', 'sortColumn', 'sortDirection', 'search', 
            'totalPosts', 'totalViews', 'userName', 'redirectEnabled',
            'postsGrowth', 'viewsGrowth'
        ));
    }

    // Create image Post
    public function create(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|max:50',
            'category' => 'required|in:image,ai',
            'links' => 'required|array',
            'links.*' => 'url|max:255',
        ]);

        do {
            $slug = Str::random(6);
        } while (Image::where('slug', $slug)->exists());

        Image::create([
            'title' => $request->title,
            'category' => $request->category,
            'links' => json_encode($request->links), // Save links as JSON
            'slug' => $slug,
            'views' => 0,
        ]);

        return redirect()->route('addimg')->withStatus("Post Created Successfully!");
    }

    // Fetch The Post Data
    public function fetch($id)
    {
        $post = Image::findOrFail($id);
        return response()->json([
            'title' => $post->title,
            'category' => $post->category,
            'links' => json_decode($post->links, true)
        ]);
    }
    
    // Update image Post
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'category' => 'required|in:image,ai',
            'links' => 'required|array',
            'links.*' => 'url|max:255',
        ]);

        $post = Image::find($request->id);
        if ($post) {
            $post->title = $request->title;
            $post->category = $request->category;
            $post->links = json_encode($request->links); // Update links as JSON
            $post->save();

            return redirect()->route('addimg')->withStatus("Post Updated Successfully!");
        }

        return redirect()->route('addimg')->withErrors("Post not found!");
    }

    // Delete image Post
    public function delete($slug)
    {
        $post = Image::where('slug', $slug)->firstOrFail();
        $post->delete();

        return redirect()->route('addimg')->withStatus("Post Deleted Successfully!");
    }

    // Display image Post
    public function display($slug, Request $request)
    {
        $ip = $request->ip();
        $post = Image::where('slug', $slug)->firstOrFail();
        $accessType = 'i';  // Changed to 'i' for wallpaper access type

        // Store access time in session
        $accessKey = "access_{$accessType}_{$post->id}";
        if (!$request->session()->has($accessKey)) {
            $request->session()->put($accessKey, now()->timestamp);
        }

        // Check valid token
        if ($request->has('token')) {
            if (AccessToken::isValid($request->token, $accessType, $post->id, $ip)) {
                ImageView::where('created_at', '<', now()->subDay())->delete();

                $viewed = ImageView::where('post_id', $post->id)
                    ->where('ip_address', $ip)
                    ->where('created_at', '>=', now()->subDay())
                    ->exists();

                if (!$viewed) {
                    ImageView::create([
                        'post_id' => $post->id,
                        'ip_address' => $ip,
                    ]);

                    $post->increment('views');
                }

                $postLinks = json_decode($post->links, true);

                return view('nsfw.image.display', compact('post', 'postLinks'));
            }

            return redirect()->to(url("/$accessType/{$slug}"));
        }

        return view('access.pre-access', [
            'accessType' => $accessType,
            'postSlug' => $slug,
            'postId' => $post->id,
        ]);
    }

    // Get Latest Image Number by Category
    public function getLatestImageNumber($category)
    {
        if (!in_array($category, ['image', 'ai'])) {
            return response()->json(['error' => 'Invalid category'], 400);
        }
        
        // Find the latest image number by parsing titles that follow the "[Category] #X" format
        $latestNumber = 0;
        
        // Get all posts with titles that might contain the pattern
        $pattern = $category === 'image' ? 'Image #%' : 'AI #%';
        $posts = Image::where('title', 'like', $pattern)->get();
        
        foreach ($posts as $post) {
            // Extract the number from the title
            $regex = $category === 'image' ? '/Image #(\d+)/' : '/AI #(\d+)/';
            if (preg_match($regex, $post->title, $matches)) {
                $number = (int) $matches[1];
                if ($number > $latestNumber) {
                    $latestNumber = $number;
                }
            }
        }
        
        return response()->json(['latestNumber' => $latestNumber]);
    }
}
