<?php
namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Edit Settings
    public function editSettings()
    {
        $settings = Settings::first() ?: new Settings();
        return view('settings.settings', compact('settings'));
    }

    // Update Settings
    public function updateSettings(Request $request)
    {
        // Settings Validation
        $settingsValidated = $request->validate([
            'active_domain' => 'nullable|url', 
            'redirect_enabled' => 'boolean', 
            'ad1' => 'nullable|string', 
            'ad2' => 'nullable|string',
        ]);

        // Update Settings
        Settings::updateOrCreate(['id' => 1], $settingsValidated);

        return back()->with('status', 'Settings updated successfully!');
    }

    // Edit Profile
    public function editProfile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        // User Validation
        $userValidated = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email,' . Auth::id(), 
            'password' => 'nullable|min:8|confirmed', 
        ]);

        // Prepare update data
        $userData = [
            'name' => $userValidated['name'],
            'email' => $userValidated['email'],
        ];
        
        // Add password only if provided
        if (!empty($userValidated['password'])) {
            $userData['password'] = Hash::make($userValidated['password']);
        }

        // Update User
        User::where('id', Auth::id())->update($userData);

        return back()->with('status', 'Profile updated successfully!');
    }

    // Toggle NSFW Setting
    public function toggleNsfw(string $status)
    {
        // Validate status
        if (!in_array($status, ['enabled', 'disabled'])) {
            return back()->with('error', 'Invalid NSFW status');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Update or create settings with the new NSFW status
        Settings::updateOrCreate(
            ['user_id' => $user->id],
            ['nsfw' => $status]
        );

        $statusMessage = $status == 'enabled' ? 'NSFW content enabled' : 'NSFW content disabled';
        return back()->with('status', $statusMessage);
    }

    // Toggle NSFW Setting via AJAX
    public function toggleNsfwAjax(Request $request)
    {
        // Validate status
        $status = $request->input('status');
        if (!in_array($status, ['enabled', 'disabled'])) {
            return response()->json(['success' => false, 'message' => 'Invalid NSFW status']);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Update or create settings with the new NSFW status
        Settings::updateOrCreate(
            ['user_id' => $user->id],
            ['nsfw' => $status]
        );
        
        // Prepare dashboard data if we're on the dashboard page
        $dashboardData = [];
        if ($request->input('on_dashboard') == true || $request->input('on_dashboard') === 'true') {
            // Calculate total posts
            $totalPosts = \App\Models\Wallpaper::count() + \App\Models\Pfp::count();
            if ($status === 'enabled') {
                $totalPosts += \App\Models\Image::count() + \App\Models\Nxleak::count() + \App\Models\Video::count();
            }
            
            // Calculate total views
            $totalViews = \App\Models\Wallpaper::sum('views') + \App\Models\Pfp::sum('views');
            if ($status === 'enabled') {
                $totalViews += \App\Models\Image::sum('views') + \App\Models\Nxleak::sum('views') + \App\Models\Video::sum('views');
            }

            // Define SFW query first (Wallpapers and PFP)
            $wallpaperQuery = \App\Models\Wallpaper::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'w' as type"));
            $pfpQuery = \App\Models\Pfp::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'p' as type"));
            
            // Define NSFW queries
            $imageQuery = \App\Models\Image::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'i' as type"));
            $nxleakQuery = \App\Models\Nxleak::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'n' as type"));
            $videoQuery = \App\Models\Video::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'v' as type"));

            // Start with SFW content query (always include PFP)
            $mostViewedQuery = $wallpaperQuery->unionAll($pfpQuery);
            
            // Add NSFW content if enabled
            if ($status === 'enabled') {
                $mostViewedQuery = $mostViewedQuery->unionAll($imageQuery)
                                               ->unionAll($nxleakQuery)
                                               ->unionAll($videoQuery);
            }
            
            // Get most viewed posts - limit to 5 for performance
            $mostViewed = $mostViewedQuery
                ->orderBy('views', 'desc')
                ->take(5)
                ->get()
                ->map(function($item) {
                    // Convert dates to ISO format for JavaScript
                    return [
                        'title' => $item->title,
                        'slug' => $item->slug,
                        'views' => $item->views,
                        'type' => $item->type,
                        'created_at' => $item->created_at->toISOString()
                    ];
                });
            
            // For recent posts, create a fresh query to avoid any issues
            $recentWallpaperQuery = \App\Models\Wallpaper::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'w' as type"));
            $recentPfpQuery = \App\Models\Pfp::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'p' as type"));
            $recentPostsQuery = $recentWallpaperQuery->unionAll($recentPfpQuery);
            
            // Add NSFW content if enabled
            if ($status === 'enabled') {
                $recentImageQuery = \App\Models\Image::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'i' as type"));
                $recentNxleakQuery = \App\Models\Nxleak::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'n' as type"));
                $recentVideoQuery = \App\Models\Video::select('title', 'slug', 'views', 'created_at', \Illuminate\Support\Facades\DB::raw("'v' as type"));
                
                $recentPostsQuery = $recentPostsQuery->unionAll($recentImageQuery)
                                                  ->unionAll($recentNxleakQuery)
                                                  ->unionAll($recentVideoQuery);
            }
            
            // Get recent posts - limit to 5 for performance
            $recentPosts = $recentPostsQuery
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function($item) {
                    // Convert dates to ISO format for JavaScript
                    return [
                        'title' => $item->title,
                        'slug' => $item->slug,
                        'views' => $item->views,
                        'type' => $item->type,
                        'created_at' => $item->created_at->toISOString()
                    ];
                });
            
            $dashboardData = [
                'totalPosts' => $totalPosts,
                'totalViews' => $totalViews,
                'mostViewed' => $mostViewed,
                'recentPosts' => $recentPosts
            ];
        }

        return response()->json(array_merge([
            'success' => true, 
            'message' => $status == 'enabled' ? 'NSFW content enabled' : 'NSFW content disabled',
            'dashboardData' => $dashboardData
        ]));
    }
}
