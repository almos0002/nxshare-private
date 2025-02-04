<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Nxleak;
use App\Models\Wallpaper;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;

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
        // Calculate total posts
        $totalPosts = Image::count() + Nxleak::count() + Wallpaper::count();
        
        // Calculate total views
        $totalViews = Image::sum('views') + Nxleak::sum('views') + Wallpaper::sum('views');
        
        // Get logged in user name
        $userName = auth()->user()->name;
        
        // Get redirect status
        $redirectStatus = Settings::value('redirect_enabled') ?? false;
        $redirectEnabled = $redirectStatus ? 'Enabled' : 'Disabled';

        // Get most viewed posts
        $mostViewed = Image::select('title', 'slug', 'views', 'created_at', DB::raw("'i' as type"))
            ->unionAll(
                Nxleak::select('title', 'slug', 'views', 'created_at', DB::raw("'n' as type"))
            )
            ->unionAll(
                Wallpaper::select('title', 'slug', 'views', 'created_at', DB::raw("'w' as type"))
            )
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Get recent posts
        $recentPosts = Image::select('title', 'slug', 'created_at', DB::raw("'i' as type"))
            ->unionAll(
                Nxleak::select('title', 'slug', 'created_at', DB::raw("'n' as type"))
            )
            ->unionAll(
                Wallpaper::select('title', 'slug', 'created_at', DB::raw("'w' as type"))
            )
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPosts',
            'totalViews',
            'userName',
            'redirectEnabled',
            'mostViewed',
            'recentPosts'
        ));
    }
}
