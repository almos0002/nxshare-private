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
                    <span class="flex items-center text-green-500 dark:text-green-400">
                        <i class="ri-arrow-up-line mr-1"></i>
                        12%
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
                    <span class="flex items-center text-green-500 dark:text-green-400">
                        <i class="ri-arrow-up-line mr-1"></i>
                        24%
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
                    <span class="flex items-center text-green-500 dark:text-green-400">
                        <i class="ri-arrow-up-line mr-1"></i>
                        8%
                    </span>
                    <span class="ml-2 text-surface-500 dark:text-surface-400">from last week</span>
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
                            <p class="text-3xl font-bold text-surface-900 dark:text-white" id="growth-percentage">
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
                                class="text-sm font-medium text-surface-900 dark:text-white">{{ number_format($growthStats['currentViews']) }}</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                            <div class="h-2.5 rounded-full bg-brand-500"
                                style="width: 100%">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="mb-1 flex items-center justify-between">
                            <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Previous period (30
                                days)</span>
                            <span
                                class="text-sm font-medium text-surface-900 dark:text-white">{{ number_format($growthStats['previousViews']) }}</span>
                        </div>
                        <div class="h-2.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                            <div class="h-2.5 rounded-full bg-surface-500"
                                style="width: {{ $growthStats['previousPercentage'] }}%">
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
                                        class="text-xs font-medium text-surface-900 dark:text-white">{{ number_format($viewDistribution['wallpaper']['count']) }}</span>
                                </div>
                                <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                    <div class="h-1.5 rounded-full bg-blue-500"
                                        style="width: {{ $viewDistribution['wallpaper']['percentage'] }}%">
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
                                        class="text-xs font-medium text-surface-900 dark:text-white">{{ number_format($viewDistribution['pfp']['count']) }}</span>
                                </div>
                                <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                    <div class="h-1.5 rounded-full bg-purple-500"
                                        style="width: {{ $viewDistribution['pfp']['percentage'] }}%">
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
                                            class="text-xs font-medium text-surface-900 dark:text-white">{{ number_format($viewDistribution['image']['count']) }}</span>
                                    </div>
                                    <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                        <div class="h-1.5 rounded-full bg-green-500"
                                            style="width: {{ $viewDistribution['image']['percentage'] }}%">
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
                                            class="text-xs font-medium text-surface-900 dark:text-white">{{ number_format($viewDistribution['nxleak']['count']) }}</span>
                                    </div>
                                    <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                        <div class="h-1.5 rounded-full bg-red-500"
                                            style="width: {{ $viewDistribution['nxleak']['percentage'] }}%">
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
                                            class="text-xs font-medium text-surface-900 dark:text-white">{{ number_format($viewDistribution['video']['count']) }}</span>
                                    </div>
                                    <div class="h-1.5 w-full rounded-full bg-surface-200 dark:bg-surface-700">
                                        <div class="h-1.5 rounded-full bg-amber-500"
                                            style="width: {{ $viewDistribution['video']['percentage'] }}%">
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
                <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Latest Views by IP</h2>
                </div>
                <div id="latest-views-container">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead class="border-b">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        IP Address</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Country</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Post</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($latestViews as $view)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $view->ip_address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <span class="inline-flex items-center">
                                                {{ $view->country }}
                                                <span
                                                    class="ml-1 text-xs text-gray-400 dark:text-gray-500">({{ $view->country_code }})</span>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center">
                                                @if ($view->type == 'w')
                                                    <span
                                                        class="inline-flex items-center justify-center text-center align-middle rounded-full px-2.5 py-1.5 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 min-w-[80px]">
                                                        Wallpaper
                                                    </span>
                                                @elseif ($view->type == 'p')
                                                    <span
                                                        class="inline-flex items-center justify-center text-center align-middle rounded-full px-2.5 py-1.5 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 min-w-[80px]">
                                                        PFP
                                                    </span>
                                                @elseif ($view->type == 'i')
                                                    <span
                                                        class="inline-flex items-center justify-center text-center align-middle rounded-full px-2.5 py-1.5 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 min-w-[80px]">
                                                        Image
                                                    </span>
                                                @elseif ($view->type == 'n')
                                                    <span
                                                        class="inline-flex items-center justify-center text-center align-middle rounded-full px-2.5 py-1.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 min-w-[80px]">
                                                        Nxleak
                                                    </span>
                                                @elseif ($view->type == 'v')
                                                    <span
                                                        class="inline-flex items-center justify-center text-center align-middle rounded-full px-2.5 py-1.5 text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400 min-w-[80px]">
                                                        Video
                                                    </span>
                                                @endif
                                                <span class="ml-2">{{ $view->title }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ \Carbon\Carbon::parse($view->created_at)->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No views found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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
            const nsfwToggle = document.getElementById('nsfw-toggle');
            const nsfwToggleText = document.getElementById('nsfw-toggle-text');
            
            if (nsfwToggle) {
                nsfwToggle.addEventListener('change', function() {
                    const isChecked = this.checked;
                    nsfwToggleText.textContent = isChecked ? 'NSFW Enabled' : 'NSFW Disabled';
                    
                    // Update dashboard data via AJAX
                    updateDashboardData(isChecked);
                });
            }
            
            // Function to update dashboard data via AJAX
            function updateDashboardData(nsfwEnabled) {
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
                        // Update total posts and views
                        document.getElementById('total-posts').textContent = data.totalPosts.toLocaleString();
                        document.getElementById('total-views').textContent = data.totalViews.toLocaleString();
                        
                        // Update most viewed posts
                        updatePostsList('most-viewed-posts', data.mostViewed);
                        
                        // Update recent posts
                        updatePostsList('recent-posts', data.recentPosts);
                        
                        // Update latest views by IP
                        updateLatestViews(data.latestViews);
                        
                        // Update view distribution
                        updateViewDistribution(data.viewDistribution, nsfwEnabled);
                        
                        // Update growth statistics
                        updateGrowthStatistics(data.growthStats);
                    }
                })
                .catch(error => {
                    console.error('Error updating dashboard data:', error);
                });
            }
            
            // Function to update posts list (most viewed or recent)
            function updatePostsList(elementId, posts) {
                const container = document.getElementById(elementId);
                if (!container) return;
                
                // Clear existing content
                container.innerHTML = '';
                
                // Add new posts
                posts.forEach(post => {
                    let typeClass = '';
                    let typeText = '';
                    
                    switch (post.type) {
                        case 'w':
                            typeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                            typeText = 'Wallpaper';
                            break;
                        case 'p':
                            typeClass = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300';
                            typeText = 'PFP';
                            break;
                        case 'i':
                            typeClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                            typeText = 'Image';
                            break;
                        case 'n':
                            typeClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                            typeText = 'Nxleak';
                            break;
                        case 'v':
                            typeClass = 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300';
                            typeText = 'Video';
                            break;
                    }
                    
                    const date = new Date(post.created_at);
                    const formattedDate = date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    
                    const postItem = document.createElement('div');
                    postItem.className = 'flex items-center justify-between py-3';
                    postItem.innerHTML = `
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-medium rounded ${typeClass}">
                                ${typeText}
                            </span>
                            <div>
                                <p class="text-sm font-medium text-surface-900 dark:text-white">${post.title}</p>
                                <p class="text-xs text-surface-500 dark:text-surface-400">${formattedDate}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-surface-900 dark:text-white">${post.views.toLocaleString()}</span>
                            <span class="ml-1 text-xs text-surface-500 dark:text-surface-400">views</span>
                        </div>
                    `;
                    
                    container.appendChild(postItem);
                });
            }
            
            // Function to update latest views by IP
            function updateLatestViews(views) {
                const container = document.getElementById('latest-views');
                if (!container) return;
                
                // Clear existing content
                container.innerHTML = '';
                
                // Add new views
                views.forEach(view => {
                    const date = new Date(view.created_at);
                    const formattedDate = date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                    const formattedTime = date.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    
                    let typeClass = '';
                    let typeText = '';
                    
                    switch (view.type) {
                        case 'w':
                            typeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                            typeText = 'Wallpaper';
                            break;
                        case 'p':
                            typeClass = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300';
                            typeText = 'PFP';
                            break;
                        case 'i':
                            typeClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                            typeText = 'Image';
                            break;
                        case 'n':
                            typeClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                            typeText = 'Nxleak';
                            break;
                        case 'v':
                            typeClass = 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300';
                            typeText = 'Video';
                            break;
                    }
                    
                    const viewItem = document.createElement('div');
                    viewItem.className = 'flex items-center justify-between py-3';
                    viewItem.innerHTML = `
                        <div class="flex items-center">
                            <span class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-medium rounded ${typeClass}">
                                ${typeText}
                            </span>
                            <div>
                                <p class="text-sm font-medium text-surface-900 dark:text-white">${view.title}</p>
                                <p class="text-xs text-surface-500 dark:text-surface-400">${formattedDate} at ${formattedTime}</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-surface-900 dark:text-white">${view.ip_address}</span>
                            <span class="ml-1 text-xs text-surface-500 dark:text-surface-400">${view.country || 'Unknown'}</span>
                        </div>
                    `;
                    
                    container.appendChild(viewItem);
                });
            }
            
            // Function to update view distribution
            function updateViewDistribution(distribution, nsfwEnabled) {
                // Update wallpaper views
                updateDistributionItem('wallpaper', distribution.wallpaper);
                
                // Update pfp views
                updateDistributionItem('pfp', distribution.pfp);
                
                // Update NSFW content if enabled
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
            
            // Function to update growth statistics
            function updateGrowthStatistics(stats) {
                // Update growth percentage
                const growthElement = document.getElementById('growth-percentage');
                if (growthElement) {
                    const sign = stats.growthPercentage > 0 ? '+' : '';
                    growthElement.textContent = `${sign}${stats.growthPercentage}%`;
                }
                
                // Update current period views
                const currentViewsElement = document.querySelector('.current-views');
                if (currentViewsElement) {
                    currentViewsElement.textContent = stats.currentViews.toLocaleString();
                }
                
                // Update previous period views
                const previousViewsElement = document.querySelector('.previous-views');
                if (previousViewsElement) {
                    previousViewsElement.textContent = stats.previousViews.toLocaleString();
                }
                
                // Update previous period bar
                const previousBarElement = document.querySelector('.previous-bar');
                if (previousBarElement) {
                    previousBarElement.style.width = `${stats.previousPercentage}%`;
                }
            }
        });
    </script>
@endsection
