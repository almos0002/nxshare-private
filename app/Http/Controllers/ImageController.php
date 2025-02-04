<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\ImageView;
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

        return view('nsfw.image.add', compact('posts', 'sortColumn', 'sortDirection', 'search'));
    }

    // Create image Post
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
        } while (Image::where('slug', $slug)->exists());

        Image::create([
            'title' => $request->title,
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
            'links' => json_decode($post->links, true)
        ]);
    }
    
    // Update image Post
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'links' => 'required|array',
            'links.*' => 'url|max:255',
        ]);

        $post = Image::find($request->id);
        if ($post) {
            $post->title = $request->title;
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
    $accessType = 'i'; // Consider using a constant

    // Remove unused session logic unless required elsewhere

    if ($request->has('token')) {
        if (AccessToken::isValid($request->token, $accessType, $post->id, $ip)) {
            // Delegate cleanup to a scheduled job instead of running here

            $lastDay = now()->subDay();
            $viewed = ImageView::where('post_id', $post->id)
                ->where('ip_address', $ip)
                ->where('created_at', '>=', $lastDay)
                ->exists();

            if (!$viewed) {
                ImageView::create([
                    'post_id' => $post->id,
                    'ip_address' => $ip,
                ]);

                $post->increment('views');
            }

            $postLinks = json_decode($post->links, true) ?? [];

            return view('nsfw.image.display', compact('post', 'postLinks'));
        }

        return redirect()->route('image.display', ['slug' => $slug])
            ->with('error', 'Invalid or expired token.');
    }

    return view('access.pre-access', [
        'accessType' => $accessType,
        'postSlug' => $slug,
        'postId' => $post->id,
    ]);
}
}
