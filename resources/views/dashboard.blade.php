@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 to-brand-800 text-white shadow-lg">
        <div class="absolute inset-0 bg-pattern opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(255,255,255,0.5)\'/%3E%3C/svg%3E');"></div>
        <div class="relative px-6 py-8 md:px-8 md:py-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name ?? 'User' }}!</h1>
                    <p class="mt-1 text-brand-100">Here's what's happening with your content today.</p>
                </div>
                <div>
                    <a href="#" class="inline-flex items-center rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition-colors hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <i class="ri-add-line mr-2"></i>
                        Create New Post
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Posts -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Total Posts</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white total-posts-value">{{ $totalPosts }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900/50 dark:text-brand-400">
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
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-500 to-brand-700 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>

        <!-- Total Views -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Total Views</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white total-views-value">{{ $totalViews }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400">
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
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-indigo-700 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>

        <!-- Logged In Users -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Logged In User</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ $userName }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400">
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
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-purple-700 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>

        <!-- Redirect Status -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Redirect Status</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ $redirectEnabled }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-400">
                    <i class="ri-link text-2xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center">
                <span class="inline-flex items-center rounded-full bg-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-100 px-2.5 py-0.5 text-xs font-medium text-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-800 dark:bg-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-900/30 dark:text-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-400">
                    {{ $redirectEnabled === 'Enabled' ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-amber-700 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>
    </div>

    <!-- Content Sections -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Top Viewed Posts -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
            <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Top Viewed Posts</h2>
            </div>
            <div class="divide-y divide-surface-200 dark:divide-surface-700">
                @foreach($mostViewed as $view)
                <div class="flex items-center p-4 transition-colors hover:bg-surface-50 dark:hover:bg-surface-700/50">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 font-bold text-brand-600 dark:bg-surface-700 dark:text-brand-400">
                            {{ substr($view->title, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <p class="truncate text-sm font-medium text-surface-900 dark:text-white">{{ $view->title }}</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">{{ $view->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-surface-500 dark:text-surface-400">
                            <i class="ri-eye-line mr-1 text-sm"></i>
                            <span class="text-xs">{{ $view->views }}</span>
                        </div>
                        <a href="/{{ $view->type == 'i' ? 'i' : ($view->type == 'n' ? 'n' : ($view->type == 'w' ? 'w' : ($view->type == 'p' ? 'p' : 'v'))) }}/{{ $view->slug }}" class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                            <i class="ri-external-link-line text-lg"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="border-t border-surface-200 bg-surface-50 px-6 py-3 dark:border-surface-700 dark:bg-surface-800/80">
                <a href="#" class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                    View all posts
                    <i class="ri-arrow-right-line ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
            <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Recent Posts</h2>
            </div>
            <div class="divide-y divide-surface-200 dark:divide-surface-700">
                @foreach($recentPosts as $post)
                <div class="flex items-center p-4 transition-colors hover:bg-surface-50 dark:hover:bg-surface-700/50">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 font-bold text-{{ $post->type === 'w' ? 'blue' : ($post->type === 'p' ? 'purple' : ($post->type === 'n' ? 'red' : ($post->type === 'i' ? 'green' : 'amber'))) }}-600 dark:bg-surface-700 dark:text-{{ $post->type === 'w' ? 'blue' : ($post->type === 'p' ? 'purple' : ($post->type === 'n' ? 'red' : ($post->type === 'i' ? 'green' : 'amber'))) }}-400">
                            {{ substr($post->title, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <p class="truncate text-sm font-medium text-surface-900 dark:text-white">{{ $post->title }}</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">{{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-surface-500 dark:text-surface-400">
                            <i class="ri-eye-line mr-1 text-sm"></i>
                            <span class="text-xs">{{ $post->views ?? 0 }}</span>
                        </div>
                        <a href="/{{ $post->type == 'i' ? 'i' : ($post->type == 'n' ? 'n' : ($post->type == 'w' ? 'w' : ($post->type == 'p' ? 'p' : 'v'))) }}/{{ $post->slug }}" class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                            <i class="ri-external-link-line text-lg"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="border-t border-surface-200 bg-surface-50 px-6 py-3 dark:border-surface-700 dark:bg-surface-800/80">
                <a href="#" class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                    View all recent posts
                    <i class="ri-arrow-right-line ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
        <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
            <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Recent Activity</h2>
        </div>
        <div class="p-6">
            <ol class="relative border-l border-surface-200 dark:border-surface-700">
                <li class="mb-6 ml-6">
                    <span class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-brand-100 ring-8 ring-white dark:bg-brand-900 dark:ring-surface-800">
                        <i class="ri-user-add-line text-sm text-brand-600 dark:text-brand-400"></i>
                    </span>
                    <div class="rounded-lg border border-surface-200 bg-surface-50 p-4 shadow-sm dark:border-surface-700 dark:bg-surface-800">
                        <div class="mb-1 text-base font-semibold text-surface-900 dark:text-white">New user registered</div>
                        <time class="mb-2 block text-sm font-normal text-surface-500 dark:text-surface-400">10 minutes ago</time>
                        <p class="text-sm font-normal text-surface-600 dark:text-surface-300">A new user has registered to the platform. Check the user management section for details.</p>
                    </div>
                </li>
                <li class="mb-6 ml-6">
                    <span class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-green-100 ring-8 ring-white dark:bg-green-900 dark:ring-surface-800">
                        <i class="ri-file-upload-line text-sm text-green-600 dark:text-green-400"></i>
                    </span>
                    <div class="rounded-lg border border-surface-200 bg-surface-50 p-4 shadow-sm dark:border-surface-700 dark:bg-surface-800">
                        <div class="mb-1 text-base font-semibold text-surface-900 dark:text-white">New content uploaded</div>
                        <time class="mb-2 block text-sm font-normal text-surface-500 dark:text-surface-400">2 hours ago</time>
                        <p class="text-sm font-normal text-surface-600 dark:text-surface-300">5 new images have been uploaded to the platform. They are pending review.</p>
                    </div>
                </li>
                <li class="ml-6">
                    <span class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full bg-red-100 ring-8 ring-white dark:bg-red-900 dark:ring-surface-800">
                        <i class="ri-alert-line text-sm text-red-600 dark:text-red-400"></i>
                    </span>
                    <div class="rounded-lg border border-surface-200 bg-surface-50 p-4 shadow-sm dark:border-surface-700 dark:bg-surface-800">
                        <div class="mb-1 text-base font-semibold text-surface-900 dark:text-white">System alert</div>
                        <time class="mb-2 block text-sm font-normal text-surface-500 dark:text-surface-400">1 day ago</time>
                        <p class="text-sm font-normal text-surface-600 dark:text-surface-300">The system has detected unusual traffic. Please check the security logs.</p>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</div>
@endsection