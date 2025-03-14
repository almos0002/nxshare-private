<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Nxleak;
use App\Models\Wallpaper;
use App\Models\Pfp;
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
        $totalPosts = Wallpaper::count() + Pfp::count();
        if ($nsfwEnabled) {
            $totalPosts += Image::count() + Nxleak::count() + Video::count();
        }
        
        // Calculate total views
        $totalViews = Wallpaper::sum('views') + Pfp::sum('views');
        if ($nsfwEnabled) {
            $totalViews += Image::sum('views') + Nxleak::sum('views') + Video::sum('views');
        }
        
        // Get logged in user name
        $userName = $user->name;
        
        // Get redirect status
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        // Start with SFW content query
        $mostViewedQuery = Wallpaper::select('title', 'slug', 'views', 'created_at', DB::raw("'w' as type"))
            ->unionAll(
                Pfp::select('title', 'slug', 'views', 'created_at', DB::raw("'p' as type"))
            );
        
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
        $recentPostsQuery = Wallpaper::select('title', 'slug', 'created_at', DB::raw("'w' as type"))
            ->unionAll(
                Pfp::select('title', 'slug', 'created_at', DB::raw("'p' as type"))
            );
        
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

    public function dashboardAjax(Request $request)
    {
        // Check NSFW status from request
        $nsfwEnabled = $request->input('nsfw_enabled') === 'true' || $request->input('nsfw_enabled') === true;
        
        // Calculate total posts
        $totalPosts = Wallpaper::count() + Pfp::count();
        if ($nsfwEnabled) {
            $totalPosts += Image::count() + Nxleak::count() + Video::count();
        }
        
        // Calculate total views
        $totalViews = Wallpaper::sum('views') + Pfp::sum('views');
        if ($nsfwEnabled) {
            $totalViews += Image::sum('views') + Nxleak::sum('views') + Video::sum('views');
        }

        // Define SFW query first (Wallpapers and PFP)
        $wallpaperQuery = Wallpaper::select('title', 'slug', 'views', 'created_at', DB::raw("'w' as type"));
        $pfpQuery = Pfp::select('title', 'slug', 'views', 'created_at', DB::raw("'p' as type"));
        
        // Define NSFW queries
        $imageQuery = Image::select('title', 'slug', 'views', 'created_at', DB::raw("'i' as type"));
        $nxleakQuery = Nxleak::select('title', 'slug', 'views', 'created_at', DB::raw("'n' as type"));
        $videoQuery = Video::select('title', 'slug', 'views', 'created_at', DB::raw("'v' as type"));

        // Start with SFW content query for most viewed (always include PFP)
        $mostViewedQuery = $wallpaperQuery->unionAll($pfpQuery);
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            $mostViewedQuery = $mostViewedQuery->unionAll($imageQuery)
                                             ->unionAll($nxleakQuery)
                                             ->unionAll($videoQuery);
        }
        
        // Get most viewed posts
        $mostViewed = $mostViewedQuery
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // For recent posts, same approach (always include PFP)
        $recentPostsQuery = $wallpaperQuery->unionAll($pfpQuery);
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            $recentPostsQuery = $recentPostsQuery->unionAll($imageQuery)
                                               ->unionAll($nxleakQuery)
                                               ->unionAll($videoQuery);
        }
        
        // Get recent posts
        $recentPosts = $recentPostsQuery
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'totalPosts' => $totalPosts,
            'totalViews' => $totalViews,
            'mostViewed' => $mostViewed,
            'recentPosts' => $recentPosts
        ]);
    }
}
