<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nxleak;
use App\Models\NxleakView;
use App\Models\Settings;
use Illuminate\Support\Str;
use App\Models\AccessToken;
use App\Utilities\CustomParsedown;
use Illuminate\Support\Facades\Auth;

class NxleakController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
    
        // Validate sort direction
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }
    
        // Query for posts, with optional search filter and pagination
        $posts = Nxleak::select("id", "title", "content", "slug", "views", "created_at")
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10); // Pagination
    
        // Stats
        $totalPosts = Nxleak::count();
        $totalViews = Nxleak::sum('views');
        
        // Calculate growth percentages
        $now = now();
        $currentMonth = $now->format('m');
        $currentYear = $now->format('Y');
        $lastMonth = $now->subMonth()->format('m');
        $lastMonthYear = $now->format('Y');
        
        // Posts growth
        $currentMonthPosts = Nxleak::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
            
        $lastMonthPosts = Nxleak::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
            
        $postsGrowth = 0;
        if ($lastMonthPosts > 0) {
            $postsGrowth = round((($currentMonthPosts - $lastMonthPosts) / $lastMonthPosts) * 100);
        } elseif ($currentMonthPosts > 0) {
            $postsGrowth = 100; // If there were no posts last month but there are this month
        }
        
        // Views growth (based on views added this month vs last month)
        $currentMonthViews = NxleakView::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
            
        $lastMonthViews = NxleakView::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)
            ->count();
            
        $viewsGrowth = 0;
        if ($lastMonthViews > 0) {
            $viewsGrowth = round((($currentMonthViews - $lastMonthViews) / $lastMonthViews) * 100);
        } elseif ($currentMonthViews > 0) {
            $viewsGrowth = 100; // If there were no views last month but there are this month
        }
        
        $userName = Auth::user()->name;
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        return view('nsfw.nxleak.add', compact(
            'posts', 'sortColumn', 'sortDirection', 'search', 
            'totalPosts', 'totalViews', 'userName', 'redirectEnabled',
            'postsGrowth', 'viewsGrowth'
        ));
    }    

    // Create the Nxleak post
    public function create(Request $request){
        $request->validate([
            'title' => 'required|max:50',

        ]);

        do {
            $slug = Str::random(6);
        } while (Nxleak::where('slug', $slug)->exists());

        $param = array(
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'views' => 0,
        );
        
        Nxleak::create($param);
        return redirect()->route('addnx')->withStatus("Post Created Successfully!");

    }
    
    // Fetch The Post Data
    public function fetch($id)
    {
        $post = Nxleak::findOrFail($id);
        return response()->json([
            'title' => $post->title,
            'content' => $post->content,
        ]);
    }

    // Update the Nxleak post
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required',
        ]);
    
        $post = Nxleak::find($request->id);
        
        if ($post) {
 
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
    
            return redirect()->route('addnx')->withStatus("Post Updated Successfully!");
        }
    
        return redirect()->route('addnx')->withErrors("Post not found!");
    }

    // Delete the Nxleak Post
    public function delete($slug)
    {
       $post = Nxleak::where('slug', $slug)->first();
       $post->delete();
       return redirect()->route('addnx')->withStatus("Post Deleted Successfully!");
    }

    // Display the Nxleak Post

    public function display($slug, Request $request)
{
    $ip = $request->ip();
    $post = Nxleak::where('slug', $slug)->firstOrFail();
    $accessType = 'n';

    // Store access time in session
    $accessKey = "access_{$accessType}_{$post->id}";
    if (!$request->session()->has($accessKey)) {
        $request->session()->put($accessKey, now()->timestamp);
    }

    // Check valid token
    if ($request->has('token')) {
        if (AccessToken::isValid($request->token, $accessType, $post->id, $ip)) {
            // Original content display logic
            $parsedown = new CustomParsedown();
            $parsedown->setBreaksEnabled(true);
            $postContent = $parsedown->text($post->content);

            NxleakView::where('created_at', '<', now()->subDay())->delete();

            $viewed = NxleakView::where('post_id', $post->id)
                ->where('ip_address', $ip)
                ->where('created_at', '>=', now()->subDay())
                ->exists();

            if (!$viewed) {
                NxleakView::create([
                    'post_id' => $post->id,
                    'ip_address' => $ip
                ]);

                $post->increment('views');
            }

            return view('nsfw.nxleak.display', compact('post', 'postContent'));
        }

        return redirect()->to(url("/$accessType/{$slug}"));
    }

    return view('access.pre-access', [
        'accessType' => $accessType,
        'postSlug' => $slug,
        'postId' => $post->id,
    ]);
}



}
