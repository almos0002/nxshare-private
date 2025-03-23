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
        $recentPostsQuery = Wallpaper::select('title', 'slug', 'views', 'created_at', DB::raw("'w' as type"))
            ->unionAll(
                Pfp::select('title', 'slug', 'views', 'created_at', DB::raw("'p' as type"))
            );
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            $recentPostsQuery = Image::select('title', 'slug', 'views', 'created_at', DB::raw("'i' as type"))
                ->unionAll(
                    Nxleak::select('title', 'slug', 'views', 'created_at', DB::raw("'n' as type"))
                )
                ->unionAll($recentPostsQuery)
                ->unionAll(
                    Video::select('title', 'slug', 'views', 'created_at', DB::raw("'v' as type"))
                );
        }
        
        // Get recent posts
        $recentPosts = $recentPostsQuery
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get latest views by IP
        $latestViews = $this->getLatestViews($nsfwEnabled);
        
        // Get view distribution by type
        $viewDistribution = $this->getViewDistribution($nsfwEnabled);
        
        // Get growth statistics
        $growthStats = $this->getGrowthStatistics($nsfwEnabled);

        // Get top country data
        $topCountry = $this->getTopCountry($nsfwEnabled);

        // Calculate post growth percentage
        $postGrowth = $this->calculatePostGrowth($nsfwEnabled);
        
        // Calculate views growth percentage
        $viewsGrowth = $this->calculateViewsGrowth($nsfwEnabled);

        return view('dashboard', compact(
            'totalPosts',
            'totalViews',
            'userName',
            'redirectEnabled',
            'mostViewed',
            'recentPosts',
            'nsfwEnabled',
            'latestViews',
            'viewDistribution',
            'growthStats',
            'topCountry',
            'postGrowth',
            'viewsGrowth'
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

        // Get latest views by IP
        $latestViews = $this->getLatestViews($nsfwEnabled);
        
        // Get view distribution by type
        $viewDistribution = $this->getViewDistribution($nsfwEnabled);
        
        // Get growth statistics
        $growthStats = $this->getGrowthStatistics($nsfwEnabled);

        // Get top country data
        $topCountry = $this->getTopCountry($nsfwEnabled);

        // Calculate post growth percentage
        $postGrowth = $this->calculatePostGrowth($nsfwEnabled);
        
        // Calculate views growth percentage
        $viewsGrowth = $this->calculateViewsGrowth($nsfwEnabled);

        return response()->json([
            'success' => true,
            'totalPosts' => $totalPosts,
            'totalViews' => $totalViews,
            'mostViewed' => $mostViewed,
            'recentPosts' => $recentPosts,
            'latestViews' => $latestViews,
            'viewDistribution' => $viewDistribution,
            'growthStats' => $growthStats,
            'topCountry' => $topCountry,
            'postGrowth' => $postGrowth,
            'viewsGrowth' => $viewsGrowth
        ]);
    }

    /**
     * Get the latest views by IP address with country information
     *
     * @param bool $nsfwEnabled Whether NSFW content is enabled
     * @return \Illuminate\Support\Collection
     */
    private function getLatestViews($nsfwEnabled)
    {
        // Get the latest views from all view tables
        $latestViews = collect();
        
        // Add wallpaper views
        try {
            $wallpaperViews = DB::table('wallpaper_views')
                ->join('wallpaper', 'wallpaper_views.post_id', '=', 'wallpaper.id')
                ->select(
                    'wallpaper_views.ip_address',
                    'wallpaper_views.created_at',
                    'wallpaper.title',
                    DB::raw("'w' as type"),
                )
                ->orderBy('wallpaper_views.created_at', 'desc')
                ->take(5)
                ->get();
            $latestViews = $latestViews->concat($wallpaperViews);
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }
        
        // Add pfp views
        try {
            $pfpViews = DB::table('pfp_views')
                ->join('pfp', 'pfp_views.post_id', '=', 'pfp.id')
                ->select(
                    'pfp_views.ip_address',
                    'pfp_views.created_at',
                    'pfp.title',
                    DB::raw("'p' as type"),
                )
                ->orderBy('pfp_views.created_at', 'desc')
                ->take(5)
                ->get();
            $latestViews = $latestViews->concat($pfpViews);
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            // Add image views
            try {
                $imageViews = DB::table('image_views')
                    ->join('image', 'image_views.post_id', '=', 'image.id')
                    ->select(
                        'image_views.ip_address',
                        'image_views.created_at',
                        'image.title',
                        DB::raw("'i' as type"),
                    )
                    ->orderBy('image_views.created_at', 'desc')
                    ->take(5)
                    ->get();
                $latestViews = $latestViews->concat($imageViews);
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
            
            // Add nxleak views
            try {
                $nxleakViews = DB::table('nxleak_views')
                    ->join('nxleak', 'nxleak_views.post_id', '=', 'nxleak.id')
                    ->select(
                        'nxleak_views.ip_address',
                        'nxleak_views.created_at',
                        'nxleak.title',
                        DB::raw("'n' as type"),
                    )
                    ->orderBy('nxleak_views.created_at', 'desc')
                    ->take(5)
                    ->get();
                $latestViews = $latestViews->concat($nxleakViews);
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
            
            // Add video views
            try {
                $videoViews = DB::table('video_views')
                    ->join('video', 'video_views.post_id', '=', 'video.id')
                    ->select(
                        'video_views.ip_address',
                        'video_views.created_at',
                        'video.title',
                        DB::raw("'v' as type"),
                    )
                    ->orderBy('video_views.created_at', 'desc')
                    ->take(5)
                    ->get();
                $latestViews = $latestViews->concat($videoViews);
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
        }
        
        // Sort by created_at and take the 5 most recent
        $latestViews = $latestViews->sortByDesc('created_at')->take(5);
        
        // Get country information for each IP address
        foreach ($latestViews as $view) {
            // Skip localhost or private IPs
            if (
                $view->ip_address == '127.0.0.1' ||
                $view->ip_address == 'localhost' ||
                strpos($view->ip_address, '192.168.') === 0 ||
                strpos($view->ip_address, '10.') === 0
            ) {
                $view->country = 'Local';
                $view->country_code = 'LO';
                continue;
            }
            
            try {
                // Use IP-API for geolocation (free tier, no API key required)
                $response = @file_get_contents('http://ip-api.com/json/' . $view->ip_address . '?fields=country,countryCode');
                if ($response) {
                    $data = json_decode($response);
                    $view->country = $data->country ?? 'Unknown';
                    $view->country_code = $data->countryCode ?? 'UN';
                } else {
                    $view->country = 'Unknown';
                    $view->country_code = 'UN';
                }
            } catch (\Exception $e) {
                $view->country = 'Unknown';
                $view->country_code = 'UN';
            }
        }
        
        return $latestViews;
    }

    /**
     * Get view distribution by type
     *
     * @param bool $nsfwEnabled Whether NSFW content is enabled
     * @return array
     */
    private function getViewDistribution($nsfwEnabled)
    {
        // Initialize view counts
        $wallpaperCount = 0;
        $pfpCount = 0;
        $imageCount = 0;
        $nxleakCount = 0;
        $videoCount = 0;

        // Get wallpaper views
        try {
            $wallpaperCount = DB::table('wallpaper_views')->count();
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }

        // Get pfp views
        try {
            $pfpCount = DB::table('pfp_views')->count();
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }

        // Get NSFW content if enabled
        if ($nsfwEnabled) {
            // Get image views
            try {
                $imageCount = DB::table('image_views')->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }

            // Get nxleak views
            try {
                $nxleakCount = DB::table('nxleak_views')->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }

            // Get video views
            try {
                $videoCount = DB::table('video_views')->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
        }

        // Calculate total views
        $totalViews = $wallpaperCount + $pfpCount + $imageCount + $nxleakCount + $videoCount;
        $totalViews = max(1, $totalViews); // Avoid division by zero

        // Calculate percentages
        $wallpaperPercentage = min(100, max(5, $wallpaperCount > 0 ? ($wallpaperCount / $totalViews) * 100 : 0));
        $pfpPercentage = min(100, max(5, $pfpCount > 0 ? ($pfpCount / $totalViews) * 100 : 0));
        $imagePercentage = min(100, max(5, $imageCount > 0 ? ($imageCount / $totalViews) * 100 : 0));
        $nxleakPercentage = min(100, max(5, $nxleakCount > 0 ? ($nxleakCount / $totalViews) * 100 : 0));
        $videoPercentage = min(100, max(5, $videoCount > 0 ? ($videoCount / $totalViews) * 100 : 0));

        return [
            'wallpaper' => [
                'count' => $wallpaperCount,
                'percentage' => $wallpaperPercentage
            ],
            'pfp' => [
                'count' => $pfpCount,
                'percentage' => $pfpPercentage
            ],
            'image' => [
                'count' => $imageCount,
                'percentage' => $imagePercentage
            ],
            'nxleak' => [
                'count' => $nxleakCount,
                'percentage' => $nxleakPercentage
            ],
            'video' => [
                'count' => $videoCount,
                'percentage' => $videoPercentage
            ],
            'total' => $totalViews
        ];
    }

    /**
     * Get growth statistics for the dashboard
     *
     * @param bool $nsfwEnabled Whether NSFW content is enabled
     * @return array
     */
    private function getGrowthStatistics($nsfwEnabled)
    {
        // Define time periods
        $currentPeriodStart = now()->subDays(30);
        $previousPeriodStart = now()->subDays(60);

        // Initialize view counts
        $currentViews = 0;
        $previousViews = 0;

        // Get wallpaper views
        try {
            $currentViews += DB::table('wallpaper_views')
                ->where('created_at', '>=', $currentPeriodStart)
                ->count();
            $previousViews += DB::table('wallpaper_views')
                ->where('created_at', '>=', $previousPeriodStart)
                ->where('created_at', '<', $currentPeriodStart)
                ->count();
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }

        // Get pfp views
        try {
            $currentViews += DB::table('pfp_views')
                ->where('created_at', '>=', $currentPeriodStart)
                ->count();
            $previousViews += DB::table('pfp_views')
                ->where('created_at', '>=', $previousPeriodStart)
                ->where('created_at', '<', $currentPeriodStart)
                ->count();
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }

        // Get NSFW content if enabled
        if ($nsfwEnabled) {
            // Get image views
            try {
                $currentViews += DB::table('image_views')
                    ->where('created_at', '>=', $currentPeriodStart)
                    ->count();
                $previousViews += DB::table('image_views')
                    ->where('created_at', '>=', $previousPeriodStart)
                    ->where('created_at', '<', $currentPeriodStart)
                    ->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }

            // Get nxleak views
            try {
                $currentViews += DB::table('nxleak_views')
                    ->where('created_at', '>=', $currentPeriodStart)
                    ->count();
                $previousViews += DB::table('nxleak_views')
                    ->where('created_at', '>=', $previousPeriodStart)
                    ->where('created_at', '<', $currentPeriodStart)
                    ->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }

            // Get video views
            try {
                $currentViews += DB::table('video_views')
                    ->where('created_at', '>=', $currentPeriodStart)
                    ->count();
                $previousViews += DB::table('video_views')
                    ->where('created_at', '>=', $previousPeriodStart)
                    ->where('created_at', '<', $currentPeriodStart)
                    ->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
        }

        // Calculate growth percentage
        $growthPercentage = 0;
        if ($previousViews > 0) {
            $growthPercentage = round((($currentViews - $previousViews) / $previousViews) * 100);
        } elseif ($currentViews > 0) {
            $growthPercentage = 100; // If there were no previous views but there are current views, that's 100% growth
        }

        // Calculate previous period percentage for the progress bar
        $previousPercentage = min(100, max(5, $previousViews > 0 ? ($previousViews / max(1, $currentViews)) * 100 : 0));

        return [
            'currentViews' => $currentViews,
            'previousViews' => $previousViews,
            'growthPercentage' => $growthPercentage,
            'previousPercentage' => $previousPercentage
        ];
    }

    /**
     * Get top country data from views
     *
     * @param bool $nsfwEnabled Whether NSFW content is enabled
     * @return array
     */
    private function getTopCountry($nsfwEnabled)
    {
        // Initialize countries array
        $countries = [];
        
        // Process wallpaper views
        try {
            $wallpaperViews = DB::table('wallpaper_views')
                ->join('wallpaper', 'wallpaper_views.post_id', '=', 'wallpaper.id')
                ->select('wallpaper_views.ip_address')
                ->get();
                
            foreach ($wallpaperViews as $view) {
                if ($view->ip_address == '127.0.0.1' || 
                    $view->ip_address == 'localhost' || 
                    strpos($view->ip_address, '192.168.') === 0) {
                    continue;
                }
                
                try {
                    $response = @file_get_contents('http://ip-api.com/json/' . $view->ip_address . '?fields=country,countryCode');
                    if ($response) {
                        $data = json_decode($response);
                        $country = $data->country ?? 'Unknown';
                        $countryCode = $data->countryCode ?? 'UN';
                        
                        if (!isset($countries[$country])) {
                            $countries[$country] = [
                                'count' => 0,
                                'code' => $countryCode
                            ];
                        }
                        
                        $countries[$country]['count']++;
                    }
                } catch (\Exception $e) {
                    // Continue silently
                }
            }
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }
        
        // Process pfp views
        try {
            $pfpViews = DB::table('pfp_views')
                ->join('pfp', 'pfp_views.post_id', '=', 'pfp.id')
                ->select('pfp_views.ip_address')
                ->get();
                
            foreach ($pfpViews as $view) {
                if ($view->ip_address == '127.0.0.1' || 
                    $view->ip_address == 'localhost' || 
                    strpos($view->ip_address, '192.168.') === 0) {
                    continue;
                }
                
                try {
                    $response = @file_get_contents('http://ip-api.com/json/' . $view->ip_address . '?fields=country,countryCode');
                    if ($response) {
                        $data = json_decode($response);
                        $country = $data->country ?? 'Unknown';
                        $countryCode = $data->countryCode ?? 'UN';
                        
                        if (!isset($countries[$country])) {
                            $countries[$country] = [
                                'count' => 0,
                                'code' => $countryCode
                            ];
                        }
                        
                        $countries[$country]['count']++;
                    }
                } catch (\Exception $e) {
                    // Continue silently
                }
            }
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }
        
        // Process NSFW views if enabled
        if ($nsfwEnabled) {
            // Process image views
            try {
                $imageViews = DB::table('image_views')
                    ->join('image', 'image_views.post_id', '=', 'image.id')
                    ->select('image_views.ip_address')
                    ->get();
                    
                foreach ($imageViews as $view) {
                    if ($view->ip_address == '127.0.0.1' || 
                        $view->ip_address == 'localhost' || 
                        strpos($view->ip_address, '192.168.') === 0) {
                        continue;
                    }
                    
                    try {
                        $response = @file_get_contents('http://ip-api.com/json/' . $view->ip_address . '?fields=country,countryCode');
                        if ($response) {
                            $data = json_decode($response);
                            $country = $data->country ?? 'Unknown';
                            $countryCode = $data->countryCode ?? 'UN';
                            
                            if (!isset($countries[$country])) {
                                $countries[$country] = [
                                    'count' => 0,
                                    'code' => $countryCode
                                ];
                            }
                            
                            $countries[$country]['count']++;
                        }
                    } catch (\Exception $e) {
                        // Continue silently
                    }
                }
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
            
            // Process nxleak views
            try {
                $nxleakViews = DB::table('nxleak_views')
                    ->join('nxleak', 'nxleak_views.post_id', '=', 'nxleak.id')
                    ->select('nxleak_views.ip_address')
                    ->get();
                    
                foreach ($nxleakViews as $view) {
                    if ($view->ip_address == '127.0.0.1' || 
                        $view->ip_address == 'localhost' || 
                        strpos($view->ip_address, '192.168.') === 0) {
                        continue;
                    }
                    
                    try {
                        $response = @file_get_contents('http://ip-api.com/json/' . $view->ip_address . '?fields=country,countryCode');
                        if ($response) {
                            $data = json_decode($response);
                            $country = $data->country ?? 'Unknown';
                            $countryCode = $data->countryCode ?? 'UN';
                            
                            if (!isset($countries[$country])) {
                                $countries[$country] = [
                                    'count' => 0,
                                    'code' => $countryCode
                                ];
                            }
                            
                            $countries[$country]['count']++;
                        }
                    } catch (\Exception $e) {
                        // Continue silently
                    }
                }
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
            
            // Process video views
            try {
                $videoViews = DB::table('video_views')
                    ->join('video', 'video_views.post_id', '=', 'video.id')
                    ->select('video_views.ip_address')
                    ->get();
                    
                foreach ($videoViews as $view) {
                    if ($view->ip_address == '127.0.0.1' || 
                        $view->ip_address == 'localhost' || 
                        strpos($view->ip_address, '192.168.') === 0) {
                        continue;
                    }
                    
                    try {
                        $response = @file_get_contents('http://ip-api.com/json/' . $view->ip_address . '?fields=country,countryCode');
                        if ($response) {
                            $data = json_decode($response);
                            $country = $data->country ?? 'Unknown';
                            $countryCode = $data->countryCode ?? 'UN';
                            
                            if (!isset($countries[$country])) {
                                $countries[$country] = [
                                    'count' => 0,
                                    'code' => $countryCode
                                ];
                            }
                            
                            $countries[$country]['count']++;
                        }
                    } catch (\Exception $e) {
                        // Continue silently
                    }
                }
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
        }
        
        // Sort countries by count in descending order
        uasort($countries, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        
        // Get the top country
        $topCountry = [
            'name' => 'Unknown',
            'code' => 'UN',
            'count' => 0,
            'percentage' => 0
        ];
        
        if (!empty($countries)) {
            $topCountryName = array_key_first($countries);
            $topCountryData = $countries[$topCountryName];
            
            // Calculate total views
            $totalViews = array_sum(array_column($countries, 'count'));
            
            // Calculate percentage
            $percentage = ($totalViews > 0) ? round(($topCountryData['count'] / $totalViews) * 100) : 0;
            
            $topCountry = [
                'name' => $topCountryName,
                'code' => $topCountryData['code'],
                'count' => $topCountryData['count'],
                'percentage' => $percentage
            ];
        }
        
        return $topCountry;
    }
    
    /**
     * Calculate post growth percentage
     *
     * @param bool $nsfwEnabled Whether NSFW content is enabled
     * @return int
     */
    private function calculatePostGrowth($nsfwEnabled)
    {
        // Define time periods
        $currentPeriodStart = now()->subDays(30);
        $previousPeriodStart = now()->subDays(60);
        
        // Get current period posts
        $currentPeriodPosts = Wallpaper::where('created_at', '>=', $currentPeriodStart)->count() + 
                             Pfp::where('created_at', '>=', $currentPeriodStart)->count();
        
        // Get previous period posts
        $previousPeriodPosts = Wallpaper::where('created_at', '>=', $previousPeriodStart)
                                       ->where('created_at', '<', $currentPeriodStart)
                                       ->count() + 
                              Pfp::where('created_at', '>=', $previousPeriodStart)
                                 ->where('created_at', '<', $currentPeriodStart)
                                 ->count();
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            $currentPeriodPosts += Image::where('created_at', '>=', $currentPeriodStart)->count() + 
                                 Nxleak::where('created_at', '>=', $currentPeriodStart)->count() + 
                                 Video::where('created_at', '>=', $currentPeriodStart)->count();
            
            $previousPeriodPosts += Image::where('created_at', '>=', $previousPeriodStart)
                                         ->where('created_at', '<', $currentPeriodStart)
                                         ->count() + 
                                  Nxleak::where('created_at', '>=', $previousPeriodStart)
                                        ->where('created_at', '<', $currentPeriodStart)
                                        ->count() + 
                                  Video::where('created_at', '>=', $previousPeriodStart)
                                       ->where('created_at', '<', $currentPeriodStart)
                                       ->count();
        }
        
        // Calculate growth percentage
        $growthPercentage = 0;
        if ($previousPeriodPosts > 0) {
            $growthPercentage = round((($currentPeriodPosts - $previousPeriodPosts) / $previousPeriodPosts) * 100);
        } elseif ($currentPeriodPosts > 0) {
            $growthPercentage = 100; // If there were no previous posts but there are current posts, that's 100% growth
        }
        
        return $growthPercentage;
    }
    
    /**
     * Calculate views growth percentage
     *
     * @param bool $nsfwEnabled Whether NSFW content is enabled
     * @return int
     */
    private function calculateViewsGrowth($nsfwEnabled)
    {
        // Define time periods
        $currentPeriodStart = now()->subDays(30);
        $previousPeriodStart = now()->subDays(60);
        
        // Get current period views
        $currentPeriodViews = 0;
        $previousPeriodViews = 0;
        
        // Get wallpaper views
        try {
            $currentPeriodViews += DB::table('wallpaper_views')
                ->where('created_at', '>=', $currentPeriodStart)
                ->count();
            $previousPeriodViews += DB::table('wallpaper_views')
                ->where('created_at', '>=', $previousPeriodStart)
                ->where('created_at', '<', $currentPeriodStart)
                ->count();
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }
        
        // Get pfp views
        try {
            $currentPeriodViews += DB::table('pfp_views')
                ->where('created_at', '>=', $currentPeriodStart)
                ->count();
            $previousPeriodViews += DB::table('pfp_views')
                ->where('created_at', '>=', $previousPeriodStart)
                ->where('created_at', '<', $currentPeriodStart)
                ->count();
        } catch (\Exception $e) {
            // Table might not exist or other DB error, continue silently
        }
        
        // Add NSFW content if enabled
        if ($nsfwEnabled) {
            // Get image views
            try {
                $currentPeriodViews += DB::table('image_views')
                    ->where('created_at', '>=', $currentPeriodStart)
                    ->count();
                $previousPeriodViews += DB::table('image_views')
                    ->where('created_at', '>=', $previousPeriodStart)
                    ->where('created_at', '<', $currentPeriodStart)
                    ->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
            
            // Get nxleak views
            try {
                $currentPeriodViews += DB::table('nxleak_views')
                    ->where('created_at', '>=', $currentPeriodStart)
                    ->count();
                $previousPeriodViews += DB::table('nxleak_views')
                    ->where('created_at', '>=', $previousPeriodStart)
                    ->where('created_at', '<', $currentPeriodStart)
                    ->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
            
            // Get video views
            try {
                $currentPeriodViews += DB::table('video_views')
                    ->where('created_at', '>=', $currentPeriodStart)
                    ->count();
                $previousPeriodViews += DB::table('video_views')
                    ->where('created_at', '>=', $previousPeriodStart)
                    ->where('created_at', '<', $currentPeriodStart)
                    ->count();
            } catch (\Exception $e) {
                // Table might not exist or other DB error, continue silently
            }
        }
        
        // Calculate growth percentage
        $growthPercentage = 0;
        if ($previousPeriodViews > 0) {
            $growthPercentage = round((($currentPeriodViews - $previousPeriodViews) / $previousPeriodViews) * 100);
        } elseif ($currentPeriodViews > 0) {
            $growthPercentage = 100; // If there were no previous views but there are current views, that's 100% growth
        }
        
        return $growthPercentage;
    }
}
