<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallpaper;
use App\Models\WallpaperView;
use App\Models\AccessToken;
use Illuminate\Support\Str;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class WallpaperController extends Controller
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

        $posts = Wallpaper::select("id", "title", "links", "slug", "views", "created_at")
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);

        // Stats
        $totalPosts = Wallpaper::count();
        $totalViews = Wallpaper::sum('views');
        $userName = Auth::check() ? Auth::user()->name : 'Guest';
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        return view('sfw.wallpaper.add', compact('posts', 'sortColumn', 'sortDirection', 'search', 'totalPosts', 'totalViews', 'userName', 'redirectEnabled'));
    }

    // Create Wallpaper Post
    public function create(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|max:50',
            'links' => 'required|array',
            'links.*' => 'url|max:255',
        ]);

        do {
            $slug = Str::random(6);
        } while (Wallpaper::where('slug', $slug)->exists());

        Wallpaper::create([
            'title' => $request->title,
            'links' => json_encode($request->links), // Save links as JSON
            'slug' => $slug,
            'views' => 0,
        ]);

        return redirect()->route('addwp')->withStatus("Post Created Successfully!");
    }

    // Fetch The Post Data
    public function fetch($id)
    {
        $post = Wallpaper::findOrFail($id);
        return response()->json([
            'title' => $post->title,
            'links' => json_decode($post->links, true)
        ]);
    }
    
    // Update Wallpaper Post
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'links' => 'required|array',
            'links.*' => 'url|max:255',
        ]);

        $post = Wallpaper::find($request->id);
        if ($post) {
            $post->title = $request->title;
            $post->links = json_encode($request->links); // Update links as JSON
            $post->save();

            return redirect()->route('addwp')->withStatus("Post Updated Successfully!");
        }

        return redirect()->route('addwp')->withErrors("Post not found!");
    }

    // Delete Wallpaper Post
    public function delete($slug)
    {
        $post = Wallpaper::where('slug', $slug)->firstOrFail();
        $post->delete();

        return redirect()->route('addwp')->withStatus("Post Deleted Successfully!");
    }

    // Display Wallpaper Post
    public function display($slug, Request $request)
    {
        $ip = $request->ip();
        $post = Wallpaper::where('slug', $slug)->firstOrFail();
        $accessType = 'w';  // Changed to 'w' for wallpaper access type

        // Store access time in session
        $accessKey = "access_{$accessType}_{$post->id}";
        if (!$request->session()->has($accessKey)) {
            $request->session()->put($accessKey, now()->timestamp);
        }

        // Check valid token
        if ($request->has('token')) {
            if (AccessToken::isValid($request->token, $accessType, $post->id, $ip)) {
                WallpaperView::where('created_at', '<', now()->subDay())->delete();

                $viewed = WallpaperView::where('post_id', $post->id)
                    ->where('ip_address', $ip)
                    ->where('created_at', '>=', now()->subDay())
                    ->exists();

                if (!$viewed) {
                    WallpaperView::create([
                        'post_id' => $post->id,
                        'ip_address' => $ip,
                    ]);

                    $post->increment('views');
                }

                $postLinks = json_decode($post->links, true);

                return view('sfw.wallpaper.display', compact('post', 'postLinks'));
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
