@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 to-brand-800 text-white shadow-lg">
            <div class="absolute inset-0 bg-pattern opacity-10"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(255,255,255,0.5)\'/%3E%3C/svg%3E');">
            </div>
            <div class="relative px-6 py-8 md:px-8 md:py-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name ?? 'User' }}!</h1>
                        <p class="mt-1 text-brand-100">Here's what's happening with your content today.</p>
                    </div>
                    <div>
                        <div
                            class="inline-flex items-center rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm">
                            <i class="ri-calendar-line mr-2"></i>
                            {{ now()->format('l, F j, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Posts -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Total Posts</p>
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white total-posts-value">
                            {{ $totalPosts }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900/50 dark:text-brand-400">
                        <i class="ri-file-list-3-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="flex items-center {{ $postGrowth >= 0 ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                        <i class="{{ $postGrowth >= 0 ? 'ri-arrow-up-line' : 'ri-arrow-down-line' }} mr-1"></i>
                        <span class="post-growth-percentage">{{ $postGrowth }}%</span>
                    </span>
                    <span class="ml-2 text-surface-500 dark:text-surface-400">from last month</span>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-500 to-brand-700 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>

            <!-- Total Views -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Total Views</p>
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white total-views-value">
                            {{ $totalViews }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400">
                        <i class="ri-eye-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="flex items-center {{ $viewsGrowth >= 0 ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                        <i class="{{ $viewsGrowth >= 0 ? 'ri-arrow-up-line' : 'ri-arrow-down-line' }} mr-1"></i>
                        <span class="views-growth-percentage">{{ $viewsGrowth }}%</span>
                    </span>
                    <span class="ml-2 text-surface-500 dark:text-surface-400">from last month</span>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-indigo-700 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>

            <!-- Logged In Users -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Logged In User</p>
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ $userName }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400">
                        <i class="ri-user-3-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="flex items-center text-surface-500 dark:text-surface-400">
                        <i class="ri-shield-check-line mr-1"></i>
                        Admin Access
                    </span>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-purple-700 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>

            <!-- Redirect Status -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Redirect Status</p>
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ $redirectEnabled }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400">
                        <i class="ri-link text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span
                        class="inline-flex items-center rounded-full bg-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-800 dark:bg-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-900/30 dark:text-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-400">
                        {{ $redirectEnabled === 'Enabled' ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-amber-700 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Top Viewed Posts -->
            <div id="top-viewed-posts-section" class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
                <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Top Viewed Posts</h2>
                </div>
                <div id="top-viewed-posts-container" class="divide-y divide-surface-200 dark:divide-surface-700">
                    @foreach ($mostViewed as $view)
                        <div
                            class="flex items-center p-4 transition-colors hover:bg-surface-50 dark:hover:bg-surface-700/50">
                            <div class="flex-shrink-0">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 font-bold text-{{ $view->type === 'w' ? 'blue' : ($view->type === 'p' ? 'purple' : ($view->type === 'n' ? 'red' : ($view->type === 'i' ? 'green' : 'amber'))) }}-600 dark:bg-surface-700 dark:text-{{ $view->type === 'w' ? 'blue' : ($view->type === 'p' ? 'purple' : ($view->type === 'n' ? 'red' : ($view->type === 'i' ? 'green' : 'amber'))) }}-400">
                                    {{ substr($view->title, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <p class="truncate text-sm font-medium text-surface-900 dark:text-white">
                                        {{ $view->title }}</p>
                                    <span
                                        class="inline-flex items-center justify-center rounded-full px-2.5 py-1.5 text-xs font-medium leading-none {{ $view->type === 'w' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : ($view->type === 'p' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : ($view->type === 'n' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : ($view->type === 'i' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'))) }}">
                                        {{ $view->type === 'w' ? 'Wallpaper' : ($view->type === 'p' ? 'PFP' : ($view->type === 'n' ? 'Nxleak' : ($view->type === 'i' ? 'Image' : 'Video'))) }}
                                    </span>
                                </div>
                                <p class="text-xs text-surface-500 dark:text-surface-400">
                                    {{ $view->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center text-surface-500 dark:text-surface-400">
                                    <i class="ri-eye-line mr-1 text-sm"></i>
                                    <span class="text-xs">{{ $view->views }}</span>
                                </div>
                                <a href="/{{ $view->type == 'i' ? 'i' : ($view->type == 'n' ? 'n' : ($view->type == 'w' ? 'w' : ($view->type == 'p' ? 'p' : 'v'))) }}/{{ $view->slug }}"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                                    <i class="ri-external-link-line text-lg"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div
                    class="border-t border-surface-200 bg-surface-50 px-6 py-3 dark:border-surface-700 dark:bg-surface-800/80">
                    <a href="#"
                        class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        View all posts
                        <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Post Views Growth -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
                <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Post Views Growth</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-3xl font-bold text-surface-900 dark:text-white growth-percentage">
                                {{ $growthStats['growthPercentage'] > 0 ? '+' : '' }}{{ $growthStats['growthPercentage'] }}%
                            </p>
                            <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">compared to previous 30 days</p>
                        </div>
                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400">
                            <i class="ri-line-chart-line text-3xl"></i>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="mb-1 flex items-center justify-between">
                            <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Current period (30
                                days)</span>
                            <span
                                class="text-sm font-medium text-surface-900 dark:text-white current-views">{{ number_format($growthStats['currentViews']) }}</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                            <div class="h-2.5 rounded-full bg-brand-500" style="width: 100%">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="mb-1 flex items-center justify-between">
                            <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Previous period (30
                                days)</span>
                            <span
                                class="text-sm font-medium text-surface-900 dark:text-white previous-views">{{ number_format($growthStats['previousViews']) }}</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                            <div class="h-2.5 rounded-full bg-surface-400 previous-bar" style="width: {{ $growthStats['previousPercentage'] }}%">
                            </div>
                        </div>
                    </div>

                    <!-- View Distribution by Type -->
                    <div class="mt-6 border-t border-surface-200 pt-5 dark:border-surface-700">
                        <h3 class="mb-4 text-sm font-semibold text-surface-900 dark:text-white">View Distribution by Type
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Wallpaper Views -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-surface-700 dark:text-surface-300">
                                        <span class="inline-block w-3 h-3 mr-1 rounded-full bg-blue-500"></span>
                                        Wallpaper
                                    </span>
                                    <span
                                        class="text-xs font-medium text-surface-900 dark:text-white wallpaper-count">{{ number_format($viewDistribution['wallpaper']['count']) }}</span>
                                </div>
                                <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                    <div class="h-1.5 rounded-full bg-blue-500 wallpaper-bar" style="width: {{ $viewDistribution['wallpaper']['percentage'] }}%">
                                    </div>
                                </div>
                            </div>

                            <!-- PFP Views -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-surface-700 dark:text-surface-300">
                                        <span class="inline-block w-3 h-3 mr-1 rounded-full bg-purple-500"></span>
                                        PFP
                                    </span>
                                    <span
                                        class="text-xs font-medium text-surface-900 dark:text-white pfp-count">{{ number_format($viewDistribution['pfp']['count']) }}</span>
                                </div>
                                <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                    <div class="h-1.5 rounded-full bg-purple-500 pfp-bar" style="width: {{ $viewDistribution['pfp']['percentage'] }}%">
                                    </div>
                                </div>
                            </div>

                            @if ($nsfwEnabled)
                                <!-- Image Views -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-medium text-surface-700 dark:text-surface-300">
                                            <span class="inline-block w-3 h-3 mr-1 rounded-full bg-green-500"></span>
                                            Image
                                        </span>
                                        <span
                                            class="text-xs font-medium text-surface-900 dark:text-white image-count">{{ number_format($viewDistribution['image']['count']) }}</span>
                                    </div>
                                    <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                        <div class="h-1.5 rounded-full bg-green-500 image-bar" style="width: {{ $viewDistribution['image']['percentage'] }}%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Nxleak Views -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-medium text-surface-700 dark:text-surface-300">
                                            <span class="inline-block w-3 h-3 mr-1 rounded-full bg-red-500"></span>
                                            Nxleak
                                        </span>
                                        <span
                                            class="text-xs font-medium text-surface-900 dark:text-white nxleak-count">{{ number_format($viewDistribution['nxleak']['count']) }}</span>
                                    </div>
                                    <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                        <div class="h-1.5 rounded-full bg-red-500 nxleak-bar" style="width: {{ $viewDistribution['nxleak']['percentage'] }}%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Video Views -->
                                <div class="col-span-2">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-medium text-surface-700 dark:text-surface-300">
                                            <span class="inline-block w-3 h-3 mr-1 rounded-full bg-amber-500"></span>
                                            Video
                                        </span>
                                        <span
                                            class="text-xs font-medium text-surface-900 dark:text-white video-count">{{ number_format($viewDistribution['video']['count']) }}</span>
                                    </div>
                                    <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                        <div class="h-1.5 rounded-full bg-amber-500 video-bar" style="width: {{ $viewDistribution['video']['percentage'] }}%">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Posts -->
            <div id="recent-posts-section" class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
                <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Recent Posts</h2>
                </div>
                <div id="recent-posts-container" class="divide-y divide-surface-200 dark:divide-surface-700">
                    @foreach ($recentPosts as $post)
                        <div
                            class="flex items-center p-4 transition-colors hover:bg-surface-50 dark:hover:bg-surface-700/50">
                            <div class="flex-shrink-0">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 font-bold text-{{ $post->type === 'w' ? 'blue' : ($post->type === 'p' ? 'purple' : ($post->type === 'n' ? 'red' : ($post->type === 'i' ? 'green' : 'amber'))) }}-600 dark:bg-surface-700 dark:text-{{ $post->type === 'w' ? 'blue' : ($post->type === 'p' ? 'purple' : ($post->type === 'n' ? 'red' : ($post->type === 'i' ? 'green' : 'amber'))) }}-400">
                                    {{ substr($post->title, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <p class="truncate text-sm font-medium text-surface-900 dark:text-white">
                                        {{ $post->title }}</p>
                                    <span
                                        class="inline-flex items-center justify-center rounded-full px-2.5 py-1.5 text-xs font-medium leading-none {{ $post->type === 'w' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : ($post->type === 'p' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : ($post->type === 'n' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : ($post->type === 'i' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'))) }}">
                                        {{ $post->type === 'w' ? 'Wallpaper' : ($post->type === 'p' ? 'PFP' : ($post->type === 'n' ? 'Nxleak' : ($post->type === 'i' ? 'Image' : 'Video'))) }}
                                    </span>
                                </div>
                                <p class="text-xs text-surface-500 dark:text-surface-400">
                                    {{ $post->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center text-surface-500 dark:text-surface-400">
                                    <i class="ri-eye-line mr-1 text-sm"></i>
                                    <span class="text-xs">{{ $post->views ?? 0 }}</span>
                                </div>
                                <a href="/{{ $post->type == 'i' ? 'i' : ($post->type == 'n' ? 'n' : ($post->type == 'w' ? 'w' : ($post->type == 'p' ? 'p' : 'v'))) }}/{{ $post->slug }}"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                                    <i class="ri-external-link-line text-lg"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div
                    class="border-t border-surface-200 bg-surface-50 px-6 py-3 dark:border-surface-700 dark:bg-surface-800/80">
                    <a href="#"
                        class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        View all recent posts
                        <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Latest Views by IP -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
                <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Latest Views by IP</h2>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                        <i class="ri-refresh-line text-lg"></i>
                    </div>
                </div>
                <div id="latest-views-container" class="p-0">
                    <div class="overflow-hidden">
                        <div class="divide-y divide-surface-200 dark:divide-surface-700">
                            @forelse ($latestViews as $view)
                                <div class="flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 dark:bg-surface-700 text-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-600 dark:text-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-400">
                                            <i class="ri-{{ $view->type == 'w' ? 'image-2' : ($view->type == 'p' ? 'user' : ($view->type == 'n' ? 'lock' : ($view->type == 'i' ? 'image' : 'video'))) }}-line text-lg"></i>
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-medium text-surface-900 dark:text-white truncate max-w-[180px]">{{ $view->title }}</span>
                                                <span class="inline-flex items-center justify-center text-center align-middle rounded-full px-2 py-0.5 text-[10px] font-medium bg-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-100 text-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-800 dark:bg-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-900/30 dark:text-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-400 min-w-[65px]">
                                                    {{ $view->type == 'w' ? 'Wallpaper' : ($view->type == 'p' ? 'PFP' : ($view->type == 'n' ? 'Nxleak' : ($view->type == 'i' ? 'Image' : 'Video'))) }}
                                                </span>
                                            </div>
                                            <div class="flex items-center text-xs text-surface-500 dark:text-surface-400 mt-1">
                                                <span class="flex items-center">
                                                    <i class="ri-time-line mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($view->created_at)->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-surface-500 dark:text-surface-400">{{ $view->ip_address }}</span>
                                            <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                                                <i class="ri-external-link-line text-lg"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center">
                                    <p class="text-surface-500 dark:text-surface-400">No views recorded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="border-t border-surface-200 bg-surface-50 px-6 py-3 dark:border-surface-700 dark:bg-surface-800/80">
                    <a href="#" class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        View all views
                        <i class="ri-arrow-right-line ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- This section intentionally left empty for future stats -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle NSFW content
            document.getElementById('nsfw-toggle').addEventListener('change', function() {
                nsfwEnabled = this.checked;
                localStorage.setItem('nsfwEnabled', nsfwEnabled);
                
                // Update toggle text
                const nsfwToggleText = document.getElementById('nsfw-toggle-text');
                if (nsfwToggleText) {
                    nsfwToggleText.textContent = nsfwEnabled ? 'NSFW Enabled' : 'NSFW Disabled';
                }
                
                // Update dashboard data via AJAX
                fetchDashboardData(nsfwEnabled);
            });

            // Function to fetch dashboard data via AJAX
            function fetchDashboardData(nsfwEnabled) {
                fetch('{{ route('dashboard.ajax') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nsfw_enabled: nsfwEnabled
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateDashboardData(data);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating dashboard data:', error);
                    });
            }

            // Function to update dashboard data
            function updateDashboardData(data) {
                // Update total posts
                document.querySelector('.total-posts-value').textContent = data.totalPosts;
                
                // Update post growth percentage
                const postGrowthElement = document.querySelector('.post-growth-percentage');
                const postGrowthParent = postGrowthElement.parentElement;
                postGrowthElement.textContent = data.postGrowth + '%';
                
                // Update post growth icon and color
                const postGrowthIcon = postGrowthParent.querySelector('i');
                if (data.postGrowth >= 0) {
                    postGrowthParent.classList.remove('text-red-500', 'dark:text-red-400');
                    postGrowthParent.classList.add('text-green-500', 'dark:text-green-400');
                    postGrowthIcon.classList.remove('ri-arrow-down-line');
                    postGrowthIcon.classList.add('ri-arrow-up-line');
                } else {
                    postGrowthParent.classList.remove('text-green-500', 'dark:text-green-400');
                    postGrowthParent.classList.add('text-red-500', 'dark:text-red-400');
                    postGrowthIcon.classList.remove('ri-arrow-up-line');
                    postGrowthIcon.classList.add('ri-arrow-down-line');
                }
                
                // Update total views
                document.querySelector('.total-views-value').textContent = data.totalViews;
                
                // Update views growth percentage
                const viewsGrowthElement = document.querySelector('.views-growth-percentage');
                const viewsGrowthParent = viewsGrowthElement.parentElement;
                viewsGrowthElement.textContent = data.viewsGrowth + '%';
                
                // Update views growth icon and color
                const viewsGrowthIcon = viewsGrowthParent.querySelector('i');
                if (data.viewsGrowth >= 0) {
                    viewsGrowthParent.classList.remove('text-red-500', 'dark:text-red-400');
                    viewsGrowthParent.classList.add('text-green-500', 'dark:text-green-400');
                    viewsGrowthIcon.classList.remove('ri-arrow-down-line');
                    viewsGrowthIcon.classList.add('ri-arrow-up-line');
                } else {
                    viewsGrowthParent.classList.remove('text-green-500', 'dark:text-green-400');
                    viewsGrowthParent.classList.add('text-red-500', 'dark:text-red-400');
                    viewsGrowthIcon.classList.remove('ri-arrow-up-line');
                    viewsGrowthIcon.classList.add('ri-arrow-down-line');
                }
                
                // Update growth stats
                document.querySelector('.growth-percentage').textContent = (data.growthStats.growthPercentage > 0 ? '+' : '') + data.growthStats.growthPercentage + '%';
                document.querySelector('.current-views').textContent = data.growthStats.currentViews.toLocaleString();
                document.querySelector('.previous-views').textContent = data.growthStats.previousViews.toLocaleString();
                document.querySelector('.previous-bar').style.width = data.growthStats.previousPercentage + '%';
                
                // Update view distribution
                updateViewDistribution(data.viewDistribution, nsfwEnabled);
                
                // Update latest views
                updateLatestViews(data.latestViews);
            }

            // Function to update view distribution
            function updateViewDistribution(distribution, nsfwEnabled) {
                // Update wallpaper views
                updateDistributionItem('wallpaper', distribution.wallpaper);

                // Update pfp views
                updateDistributionItem('pfp', distribution.pfp);

                // Process NSFW content if enabled
                if (nsfwEnabled) {
                    // Update image views
                    updateDistributionItem('image', distribution.image);

                    // Update nxleak views
                    updateDistributionItem('nxleak', distribution.nxleak);

                    // Update video views
                    updateDistributionItem('video', distribution.video);

                    // Show NSFW distribution items
                    document.querySelectorAll('.nsfw-distribution-item').forEach(item => {
                        item.style.display = 'block';
                    });
                } else {
                    // Hide NSFW distribution items
                    document.querySelectorAll('.nsfw-distribution-item').forEach(item => {
                        item.style.display = 'none';
                    });
                }
            }

            // Function to update a single distribution item
            function updateDistributionItem(type, data) {
                const countElement = document.querySelector(`.${type}-count`);
                const barElement = document.querySelector(`.${type}-bar`);

                if (countElement && barElement) {
                    countElement.textContent = data.count.toLocaleString();
                    barElement.style.width = `${data.percentage}%`;
                }
            }

            // Function to update latest views by IP
            function updateLatestViews(views) {
                const container = document.getElementById('latest-views-container');
                if (!container) return;

                // Create a new div to hold the views
                const viewsContainer = document.createElement('div');
                viewsContainer.className = 'overflow-hidden';
                
                const viewsList = document.createElement('div');
                viewsList.className = 'divide-y divide-surface-200 dark:divide-surface-700';

                // Add views to the container
                if (views.length === 0) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'p-6 text-center';
                    emptyDiv.innerHTML = '<p class="text-surface-500 dark:text-surface-400">No views recorded yet.</p>';
                    viewsList.appendChild(emptyDiv);
                } else {
                    views.forEach(view => {
                        // Determine type class and text
                        let typeClass = '';
                        let typeText = '';
                        let typeIcon = '';
                        
                        switch (view.type) {
                            case 'w':
                                typeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400';
                                typeText = 'Wallpaper';
                                typeIcon = 'image-2';
                                typeColor = 'blue';
                                break;
                            case 'p':
                                typeClass =
                                    'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400';
                                typeText = 'PFP';
                                typeIcon = 'user';
                                typeColor = 'purple';
                                break;
                            case 'i':
                                typeClass =
                                    'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                typeText = 'Image';
                                typeIcon = 'image';
                                typeColor = 'green';
                                break;
                            case 'n':
                                typeClass = 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                                typeText = 'Nxleak';
                                typeIcon = 'lock';
                                typeColor = 'red';
                                break;
                            case 'v':
                                typeClass =
                                    'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400';
                                typeText = 'Video';
                                typeIcon = 'video';
                                typeColor = 'amber';
                                break;
                        }
                        
                        // Create view item
                        const viewItem = document.createElement('div');
                        viewItem.className = 'flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors';
                        
                        // Calculate time ago
                        const now = new Date();
                        const viewDate = new Date(view.created_at);
                        const diffMs = now - viewDate;
                        const diffSec = Math.round(diffMs / 1000);
                        const diffMin = Math.round(diffSec / 60);
                        const diffHour = Math.round(diffMin / 60);
                        const diffDay = Math.round(diffHour / 24);
                        
                        let timeAgo = '';
                        if (diffSec < 60) {
                            timeAgo = `${diffSec} second${diffSec !== 1 ? 's' : ''} ago`;
                        } else if (diffMin < 60) {
                            timeAgo = `${diffMin} minute${diffMin !== 1 ? 's' : ''} ago`;
                        } else if (diffHour < 24) {
                            timeAgo = `${diffHour} hour${diffHour !== 1 ? 's' : ''} ago`;
                        } else {
                            timeAgo = `${diffDay} day${diffDay !== 1 ? 's' : ''} ago`;
                        }
                        
                        viewItem.innerHTML = `
                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 dark:bg-surface-700 text-${typeColor}-600 dark:text-${typeColor}-400">
                                    <i class="ri-${typeIcon}-line text-lg"></i>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-surface-900 dark:text-white truncate max-w-[180px]">${view.title}</span>
                                        <span class="inline-flex items-center justify-center text-center align-middle rounded-full px-2 py-0.5 text-[10px] font-medium ${typeClass} min-w-[65px]">
                                            ${typeText}
                                        </span>
                                    </div>
                                    <div class="flex items-center text-xs text-surface-500 dark:text-surface-400 mt-1">
                                        <span class="flex items-center">
                                            <i class="ri-time-line mr-1"></i>
                                            ${timeAgo}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="flex items-center space-x-2">
                                    <span class="text-xs text-surface-500 dark:text-surface-400">${view.ip_address}</span>
                                    <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                                        <i class="ri-external-link-line text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        `;
                        
                        viewsList.appendChild(viewItem);
                    });
                }
                
                viewsContainer.appendChild(viewsList);
                
                // Clear existing content and add new content
                container.innerHTML = '';
                container.appendChild(viewsContainer);
            }
        });
    </script>
@endsection
