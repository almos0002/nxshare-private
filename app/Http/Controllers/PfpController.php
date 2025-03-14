<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pfp;
use App\Models\PfpView;
use App\Models\AccessToken;
use Illuminate\Support\Str;
use App\Models\Settings;

class PfpController extends Controller
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

        $posts = Pfp::select("id", "title", "links", "slug", "views", "created_at")
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);

        // Stats
        $totalPosts = Pfp::count();
        $totalViews = Pfp::sum('views');
        $userName = auth()->user()->name;
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        return view('sfw.pfp.add', compact('posts', 'sortColumn', 'sortDirection', 'search', 'totalPosts', 'totalViews', 'userName', 'redirectEnabled'));
    }

    // Create Pfp Post
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'links' => 'required|array',
            'links.*' => 'url|max:255',
        ]);

        do {
            $slug = Str::random(6);
        } while (Pfp::where('slug', $slug)->exists());

        Pfp::create([
            'title' => $request->title,
            'links' => json_encode($request->links), // Save links as JSON
            'slug' => $slug,
            'views' => 0,
        ]);

        return redirect()->route('addpfp')->withStatus("Post Created Successfully!");
    }

    // Fetch The Post Data
    public function fetch($id)
    {
        $post = Pfp::findOrFail($id);
        return response()->json([
            'title' => $post->title,
            'links' => json_decode($post->links, true)
        ]);
    }
    
    // Update Pfp Post
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'links' => 'required|array',
            'links.*' => 'url|max:255',
        ]);

        $post = Pfp::find($request->id);
        if ($post) {
            $post->title = $request->title;
            $post->links = json_encode($request->links); // Update links as JSON
            $post->save();

            return redirect()->route('addpfp')->withStatus("Post Updated Successfully!");
        }

        return redirect()->route('addpfp')->withErrors("Post not found!");
    }

    // Delete Pfp Post
    public function delete($slug)
    {
        $post = Pfp::where('slug', $slug)->firstOrFail();
        $post->delete();

        return redirect()->route('addpfp')->withStatus("Post Deleted Successfully!");
    }

    // Display Pfp Post
    public function display($slug, Request $request)
    {
        $ip = $request->ip();
        $post = Pfp::where('slug', $slug)->firstOrFail();
        $accessType = 'p';  // Changed to 'p' for pfp access type

        // Store access time in session
        $accessKey = "access_{$accessType}_{$post->id}";
        if (!$request->session()->has($accessKey)) {
            $request->session()->put($accessKey, now()->timestamp);
        }

        // Check valid token
        if ($request->has('token')) {
            if (AccessToken::isValid($request->token, $accessType, $post->id, $ip)) {
                PfpView::where('created_at', '<', now()->subDay())->delete();

                $viewed = PfpView::where('post_id', $post->id)
                    ->where('ip_address', $ip)
                    ->where('created_at', '>=', now()->subDay())
                    ->exists();

                if (!$viewed) {
                    PfpView::create([
                        'post_id' => $post->id,
                        'ip_address' => $ip,
                    ]);

                    $post->increment('views');
                }

                $postLinks = json_decode($post->links, true);

                return view('sfw.pfp.display', compact('post', 'postLinks'));
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
