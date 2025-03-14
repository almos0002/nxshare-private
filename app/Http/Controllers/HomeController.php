<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Nxleak;
use App\Models\Wallpaper;
use App\Models\Video;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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


    public function index()
    {
        // Get current user
        $user = Auth::user();
        
        // Check NSFW status
        $nsfwEnabled = false;
        if ($user->settings && $user->settings->nsfw === 'enabled') {
            $nsfwEnabled = true;
        }

        // Calculate total posts
        $totalPosts = Wallpaper::count();
        if ($nsfwEnabled) {
            $totalPosts += Image::count() + Nxleak::count() + Video::count();
        }
        
        // Calculate total views
        $totalViews = Wallpaper::sum('views');
        if ($nsfwEnabled) {
            $totalViews += Image::sum('views') + Nxleak::sum('views') + Video::sum('views');
        }
        
        // Get logged in user name
        $userName = $user->name;
        
        // Get redirect status
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        // Start with SFW content query
        $mostViewedQuery = Wallpaper::select('title', 'slug', 'views', 'created_at', DB::raw("'w' as type"));
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            $mostViewedQuery = Image::select('title', 'slug', 'views', 'created_at', DB::raw("'i' as type"))
                ->unionAll(
                    Nxleak::select('title', 'slug', 'views', 'created_at', DB::raw("'n' as type"))
                )
                ->unionAll($mostViewedQuery)
                ->unionAll(
                    Video::select('title', 'slug', 'views', 'created_at', DB::raw("'v' as type"))
                );
        }
        
        // Get most viewed posts
        $mostViewed = $mostViewedQuery
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Start with SFW content query for recent posts
        $recentPostsQuery = Wallpaper::select('title', 'slug', 'created_at', DB::raw("'w' as type"));
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            $recentPostsQuery = Image::select('title', 'slug', 'created_at', DB::raw("'i' as type"))
                ->unionAll(
                    Nxleak::select('title', 'slug', 'created_at', DB::raw("'n' as type"))
                )
                ->unionAll($recentPostsQuery)
                ->unionAll(
                    Video::select('title', 'slug', 'created_at', DB::raw("'v' as type"))
                );
        }
        
        // Get recent posts
        $recentPosts = $recentPostsQuery
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPosts',
            'totalViews',
            'userName',
            'redirectEnabled',
            'mostViewed',
            'recentPosts',
            'nsfwEnabled'
        ));
    }
}
