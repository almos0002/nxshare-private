<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nxleak;
use App\Models\NxleakView;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Parsedown;
use App\Services\CustomParsedown;

class NxLeakController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
    
        return view('nsfw.nxleak.add', compact('posts', 'sortColumn', 'sortDirection', 'search'));
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
        $ipAddress = $request->ip();
    
        $post = Nxleak::where('slug', $slug)->firstOrFail();

        $parsedown = new CustomParsedown();
        $postContent = $parsedown->text($post->content);

        NxleakView::where('created_at', '<', now()->subDay())->delete();
    
        $viewed = NxleakView::where('post_id', $post->id)
                          ->where('ip_address', $ipAddress)
                          ->where('created_at', '>=', now()->subDay())
                          ->exists();
    
        if (!$viewed) {
            NxleakView::create([
                'post_id' => $post->id,
                'ip_address' => $ipAddress
            ]);
    
            $post->increment('views');
        }
    
        return view('nsfw.nxleak.display', compact('post', 'postContent'));
    }


}
