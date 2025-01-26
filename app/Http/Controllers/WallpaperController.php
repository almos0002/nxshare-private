<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallpaper;
use App\Models\WallpaperView;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class WallpaperController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

        return view('sfw.wallpaper.add', compact('posts', 'sortColumn', 'sortDirection', 'search'));
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
        $ipAddress = $request->ip();
        $post = Wallpaper::where('slug', $slug)->firstOrFail();

        WallpaperView::where('created_at', '<', now()->subDay())->delete();

        $viewed = WallpaperView::where('post_id', $post->id)
            ->where('ip_address', $ipAddress)
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if (!$viewed) {
            WallpaperView::create([
                'post_id' => $post->id,
                'ip_address' => $ipAddress,
            ]);

            $post->increment('views');
        }

        $postLinks = json_decode($post->links, true);

        return view('sfw.wallpaper.display', compact('post', 'postLinks'));
    }
}
