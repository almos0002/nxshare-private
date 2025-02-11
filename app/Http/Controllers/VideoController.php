<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoView;
use App\Models\AccessToken;
use Illuminate\Support\Str;
use App\Models\Settings;

class VideoController extends Controller
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

        $posts = Video::select("id", "title", "thumbnail", "links", "slug", "views", "created_at")
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy($sortColumn, $sortDirection)
            ->paginate(10);

        // Stats
        $totalPosts = Video::count();
        $totalViews = Video::sum('views');
        $userName = auth()->user()->name;
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        return view('nsfw.video.add', compact('posts', 'sortColumn', 'sortDirection', 'search', 'totalPosts', 'totalViews', 'userName', 'redirectEnabled'));
    }

    // Create Video Post
    public function create(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|max:500',
            'thumbnail' => 'required',
            'links' => 'required',
            'links.*' => 'url|max:255',
        ]);

        do {
            $slug = Str::random(6);
        } while (Video::where('slug', $slug)->exists());

        Video::create([
            'title' => $request->title,
            'thumbnail' => $request->thumbnail,
            'links' => $request->links, // Save links as JSON
            'slug' => $slug,
            'views' => 0,
        ]);

        return redirect()->route('addvd')->withStatus("Post Created Successfully!");
    }

    // Fetch The Post Data
    public function fetch($id)
    {
        $post = Video::findOrFail($id);
        return response()->json([
            'title' => $post->title,
            'thumbnail' => $post->thumbnail,
            'links' => $post->links,
        ]);
    }
    
    // Update Video Post
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|max:500',
            'thumbnail' => 'required',
            'links' => 'required',
            'links.*' => 'url|max:255',
        ]);

        $post = Video::find($request->id);
        if ($post) {
            $post->title = $request->title;
            $post->thumbnail = $request->thumbnail;
            $post->links = $request->links; // Update links as JSON
            $post->save();

            return redirect()->route('addvd')->withStatus("Post Updated Successfully!");
        }

        return redirect()->route('addvd')->withErrors("Post not found!");
    }

    // Delete Video Post
    public function delete($slug)
    {
        $post = Video::where('slug', $slug)->firstOrFail();
        $post->delete();

        return redirect()->route('addvd')->withStatus("Post Deleted Successfully!");
    }

    // Display Video Post
    public function display($slug, Request $request)
    {
        $ip = $request->ip();
        $post = Video::where('slug', $slug)->firstOrFail();
        $accessType = 'v';  // Changed to 'v' for Video access type

        // Store access time in session
        $accessKey = "access_{$accessType}_{$post->id}";
        if (!$request->session()->has($accessKey)) {
            $request->session()->put($accessKey, now()->timestamp);
        }

        // Check valid token
        if ($request->has('token')) {
            if (AccessToken::isValid($request->token, $accessType, $post->id, $ip)) {
                VideoView::where('created_at', '<', now()->subDay())->delete();

                $viewed = VideoView::where('post_id', $post->id)
                    ->where('ip_address', $ip)
                    ->where('created_at', '>=', now()->subDay())
                    ->exists();

                if (!$viewed) {
                    VideoView::create([
                        'post_id' => $post->id,
                        'ip_address' => $ip,
                    ]);

                    $post->increment('views');
                }

                $postThumbnail = $post->thumbnail;
                $postLinks = $post->links;

                return view('nsfw.video.display', compact('post', 'postLinks', 'postThumbnail'));
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
