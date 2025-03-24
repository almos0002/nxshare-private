@extends('layouts.app')

@section('title', 'All Views')

@section('content')
    <div class="space-y-8">
        <!-- Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 to-brand-800 text-white shadow-lg">
            <div class="absolute inset-0 bg-pattern opacity-10"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(255,255,255,0.5)\'/%3E%3C/svg%3E');">
            </div>
            <div class="relative px-6 py-8 md:px-8 md:py-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl font-bold">All Content Views</h1>
                        <p class="mt-1 text-brand-100">View history of all content interactions</p>
                    </div>
                    <div>
                        <a href="{{ route('dashboard') }}" 
                            class="inline-flex items-center rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm hover:bg-white/20 transition-colors">
                            <i class="ri-dashboard-line mr-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Views List -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
            <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Content View History</h2>
                <div class="text-sm text-surface-500 dark:text-surface-400">
                    <span>{{ count($latestViews) }} total views</span>
                </div>
            </div>
            
            <div class="overflow-hidden">
                <div class="divide-y divide-surface-200 dark:divide-surface-700">
                    @forelse ($latestViews as $view)
                        <div class="flex items-center justify-between p-4 hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 font-bold text-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-600 dark:bg-surface-700 dark:text-{{ $view->type == 'w' ? 'blue' : ($view->type == 'p' ? 'purple' : ($view->type == 'n' ? 'red' : ($view->type == 'i' ? 'green' : 'amber'))) }}-400">
                                    {{ substr($view->title, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-surface-900 dark:text-white truncate max-w-[180px] md:max-w-[300px]">{{ $view->title }}</span>
                                        <span class="inline-flex items-center justify-center text-center align-middle rounded-full px-2 py-0.5 text-[10px] font-medium {{ $view->type == 'w' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : ($view->type == 'p' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : ($view->type == 'n' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : ($view->type == 'i' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'))) }} min-w-[65px]">
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
                                <div class="flex items-center space-x-4">
                                    <div class="hidden md:flex items-center text-surface-500 dark:text-surface-400">
                                        <i class="ri-global-line mr-1 text-sm"></i>
                                        <span class="text-xs">{{ $view->ip_address }}</span>
                                    </div>
                                    <a href="/{{ $view->type == 'i' ? 'i' : ($view->type == 'n' ? 'n' : ($view->type == 'w' ? 'w' : ($view->type == 'p' ? 'p' : 'v'))) }}/{{ $view->slug }}"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
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
            
            <div class="border-t border-surface-200 bg-surface-50 px-6 py-3 dark:border-surface-700 dark:bg-surface-800/80 flex justify-between items-center">
                <span class="text-sm text-surface-500 dark:text-surface-400">
                    Showing {{ $latestViews->firstItem() }} to {{ $latestViews->lastItem() }} of {{ $latestViews->total() }} views
                </span>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300">
                        <i class="ri-arrow-left-line mr-1"></i>
                        Back to Dashboard
                    </a>
                    {{ $latestViews->onEachSide(1)->links('pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
@endsection
