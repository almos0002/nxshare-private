@extends('layouts.app')

@section('title', 'Profile Pictures')

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
                        <h1 class="text-2xl font-bold">Profile Pictures Management</h1>
                        <p class="mt-1 text-brand-100">Manage your profile pictures collection here.</p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="createModal()"
                            class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-green-600 shadow-sm hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all">
                            <i class="ri-add-line mr-2"></i>
                            Add New PFP
                        </button>
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
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">
                            {{ number_format($totalPosts) }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-100 text-brand-600 dark:bg-brand-900/50 dark:text-brand-400">
                        <i class="ri-file-list-3-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if ($postsGrowth > 0)
                        <span class="flex items-center text-green-500 dark:text-green-400">
                            <i class="ri-arrow-up-line mr-1"></i>
                            {{ $postsGrowth }}%
                        </span>
                    @elseif($postsGrowth < 0)
                        <span class="flex items-center text-red-500 dark:text-red-400">
                            <i class="ri-arrow-down-line mr-1"></i>
                            {{ abs($postsGrowth) }}%
                        </span>
                    @else
                        <span class="flex items-center text-surface-500 dark:text-surface-400">
                            <i class="ri-subtract-line mr-1"></i>
                            0%
                        </span>
                    @endif
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
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">
                            {{ number_format($totalViews) }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400">
                        <i class="ri-eye-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if ($viewsGrowth > 0)
                        <span class="flex items-center text-green-500 dark:text-green-400">
                            <i class="ri-arrow-up-line mr-1"></i>
                            {{ $viewsGrowth }}%
                        </span>
                    @elseif($viewsGrowth < 0)
                        <span class="flex items-center text-red-500 dark:text-red-400">
                            <i class="ri-arrow-down-line mr-1"></i>
                            {{ abs($viewsGrowth) }}%
                        </span>
                    @else
                        <span class="flex items-center text-surface-500 dark:text-surface-400">
                            <i class="ri-subtract-line mr-1"></i>
                            0%
                        </span>
                    @endif
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

        <!-- Search and Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
            <div class="w-full sm:w-auto">
                <form class="flex" action="{{ route('addpfp') }}" method="GET">
                    <div class="relative flex-grow">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="ri-search-line text-surface-400 dark:text-surface-500"></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Search posts..." name="search"
                            value="{{ request('search') }}"
                            class="w-full rounded-lg bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 focus:border-brand-500 focus:ring focus:ring-brand-200 dark:focus:ring-brand-800 dark:focus:border-brand-500 py-2 px-3">
                    </div>
                    <button type="submit"
                        class="ml-2 inline-flex items-center justify-center px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-medium transition-colors">
                        <i class="ri-search-line mr-1"></i>
                        Search
                    </button>
                </form>
            </div>
            <div class="flex space-x-2">
                <button onClick="window.location.href = window.location.pathname;"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-600 font-medium transition-colors">
                    <i class="ri-dashboard-line mr-1"></i>
                    Dashboard
                </button>
                <button onclick="createModal()"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-medium transition-colors">
                    <i class="ri-add-line mr-1"></i>
                    Add PFP
                </button>
            </div>
        </div>

        <!-- Create Post Modal -->
        <div id="createmodal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                <div class="fixed inset-0 bg-surface-900/75 backdrop-blur-sm transition-opacity" onclick="createModal()">
                </div>

                <div
                    class="inline-block align-middle bg-white dark:bg-surface-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
                    <div class="px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium leading-6 text-surface-900 dark:text-white">Add New Post</h3>
                            <button type="button" onclick="createModal()"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200">
                                <i class="ri-close-line text-xl"></i>
                            </button>
                        </div>

                        <form id="postForm" method="post" action="{{ route('createpfp') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="title"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Title</label>
                                    <input type="text" name="title" id="title" placeholder="Enter title"
                                        required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-brand-500 focus:ring focus:ring-brand-200 dark:focus:ring-brand-800 dark:focus:border-brand-500 py-2 px-3">
                                </div>

                                <div id="linkFields">
                                    <div class="flex items-center justify-between mb-2">
                                        <label
                                            class="block text-sm font-medium text-surface-700 dark:text-surface-300">Links</label>
                                        <button type="button" onclick="addLinkField(this)"
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition-colors">
                                            <i class="ri-add-circle-fill mr-1"></i>
                                            Add Link
                                        </button>
                                    </div>

                                    <div class="link-group flex items-center space-x-2 mb-2">
                                        <div class="w-20 flex-shrink-0">
                                            <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Link
                                                1</span>
                                        </div>
                                        <div class="flex-grow">
                                            <input type="text" name="links[]" placeholder="Enter Link" required
                                                class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-brand-500 focus:ring focus:ring-brand-200 dark:focus:ring-brand-800 dark:focus:border-brand-500 py-2 px-3">
                                        </div>
                                        <button type="button" onclick="removeLinkField(this)"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors">
                                            <i class="ri-delete-bin-6-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 sm:mt-6 flex space-x-2 justify-end">
                                <button type="button" onclick="createModal()"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-600 font-medium transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-medium transition-colors">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Post Modal -->
        <div id="updatemodal" class="hidden fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
                <div class="fixed inset-0 bg-surface-900/75 backdrop-blur-sm transition-opacity" onclick="updateModal()">
                </div>

                <div
                    class="inline-block align-middle bg-white dark:bg-surface-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
                    <div class="px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium leading-6 text-surface-900 dark:text-white">Update Post</h3>
                            <button type="button" onclick="updateModal()"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200">
                                <i class="ri-close-line text-xl"></i>
                            </button>
                        </div>

                        <form id="updateForm" method="post" action="{{ route('updatepfp') }}">
                            @csrf
                            <input type="hidden" id="postId" name="id">

                            <div class="space-y-4">
                                <div>
                                    <label for="oldtitle"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Title</label>
                                    <input type="text" name="title" id="oldtitle" placeholder="Enter title"
                                        required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-brand-500 focus:ring focus:ring-brand-200 dark:focus:ring-brand-800 dark:focus:border-brand-500 py-2 px-3">
                                </div>

                                <div id="updateLinkFields">
                                    <div class="flex items-center justify-between mb-2">
                                        <label
                                            class="block text-sm font-medium text-surface-700 dark:text-surface-300">Links</label>
                                        <button type="button" onclick="addLinkField(this)"
                                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-medium transition-colors">
                                            <i class="ri-add-circle-fill mr-1"></i>
                                            Add Link
                                        </button>
                                    </div>

                                    <div class="link-group flex items-center space-x-2 mb-2">
                                        <div class="w-20 flex-shrink-0">
                                            <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Link
                                                1</span>
                                        </div>
                                        <div class="flex-grow">
                                            <input type="text" name="links[]" placeholder="Enter Link" required
                                                class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-brand-500 focus:ring focus:ring-brand-200 dark:focus:ring-brand-800 dark:focus:border-brand-500 py-2 px-3">
                                        </div>
                                        <button type="button" onclick="removeLinkField(this)"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors">
                                            <i class="ri-delete-bin-6-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 sm:mt-6 flex space-x-2 justify-end">
                                <button type="button" onclick="updateModal()"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-600 font-medium transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-medium transition-colors">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Table -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
            <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Profile Pictures</h2>
                <span
                    class="inline-flex items-center rounded-full bg-brand-50 px-2.5 py-0.5 text-xs font-medium text-brand-700 dark:bg-brand-900/30 dark:text-brand-400">
                    {{ count($posts) }} posts
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr
                            class="bg-surface-50 dark:bg-surface-700/50 border-b border-surface-200 dark:border-surface-700">
                            <th
                                class="whitespace-nowrap px-4 py-3.5 text-center w-16 text-sm font-medium text-surface-500 dark:text-surface-400">
                                SN</th>
                            <th
                                class="whitespace-nowrap px-4 py-3.5 text-left text-sm font-medium text-surface-500 dark:text-surface-400">
                                Title</th>
                            <th
                                class="whitespace-nowrap px-4 py-3.5 text-center w-24 text-sm font-medium text-surface-500 dark:text-surface-400">
                                Views</th>
                            <th
                                class="whitespace-nowrap px-4 py-3.5 text-center w-24 text-sm font-medium text-surface-500 dark:text-surface-400">
                                Slug</th>
                            <th
                                class="whitespace-nowrap px-4 py-3.5 text-center w-32 text-sm font-medium text-surface-500 dark:text-surface-400">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                        @if (count($posts))
                            @foreach ($posts as $index => $post)
                                <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                                    <td
                                        class="whitespace-nowrap px-4 py-3.5 text-center text-sm text-surface-500 dark:text-surface-400 font-medium">
                                        {{ $posts->firstItem() + $index }}</td>
                                    <td class="px-4 py-3.5 text-sm font-medium text-surface-900 dark:text-white">
                                        <div class="flex items-center">
                                            <div
                                                class="h-9 w-9 flex-shrink-0 rounded-md bg-brand-100 dark:bg-brand-900/30 flex items-center justify-center text-brand-600 dark:text-brand-400 mr-3 font-bold">
                                                {{ substr($post->title, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-surface-900 dark:text-white">
                                                    {{ $post->title }}</div>
                                                <div class="text-xs text-surface-500 dark:text-surface-400">Added
                                                    {{ $post->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3.5 text-center">
                                        <span
                                            class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                            <i class="ri-eye-line mr-1"></i> {{ number_format($post->views) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3.5 text-center">
                                        <span
                                            class="inline-flex items-center rounded-md bg-surface-100 px-2 py-1 text-xs font-medium text-surface-700 dark:bg-surface-700 dark:text-surface-300">
                                            {{ $post->slug }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3.5">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('displaypfp', $post->slug) }}"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-100 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400 hover:bg-brand-200 dark:hover:bg-brand-800/50 transition-colors"
                                                title="View">
                                                <i class="ri-eye-fill"></i>
                                            </a>
                                            <button data-id="{{ $post->id }}" onclick="populateUpdateModal(this)"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-800/50 transition-colors"
                                                title="Edit">
                                                <i class="ri-edit-fill"></i>
                                            </button>
                                            <button data-title="{{ $post->title }}" data-slug="{{ $post->slug }}"
                                                onclick="copyPromotionalText(this)"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-800/50 transition-colors"
                                                title="Copy to Clipboard">
                                                <i class="ri-clipboard-line"></i>
                                            </button>
                                            <a href="{{ route('deletepfp', $post->slug) }}"
                                                onclick="return confirm('Are you sure you want to delete this post?')"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors"
                                                title="Delete">
                                                <i class="ri-delete-bin-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5"
                                    class="px-4 py-8 text-center text-sm text-surface-500 dark:text-surface-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="h-12 w-12 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center text-surface-400 dark:text-surface-500 mb-3">
                                            <i class="ri-inbox-line text-2xl"></i>
                                        </div>
                                        <p class="text-surface-900 dark:text-white font-medium">No posts found</p>
                                        <p class="text-surface-500 dark:text-surface-400 text-sm mt-1">Start by adding a
                                            new profile picture post</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="border-t border-surface-200 bg-surface-50 px-6 py-4 dark:border-surface-700 dark:bg-surface-800/80">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <p class="text-sm text-surface-500 dark:text-surface-400">
                        Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }}
                        posts
                    </p>
                    <div>
                        {{ $posts->appends(request()->except('page'))->links('pagination::default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('updatescript')
    <script>
        function createModal() {
            const modal = document.getElementById("createmodal");
            modal.classList.toggle("hidden");
        }

        function updateModal() {
            const modal = document.getElementById("updatemodal");
            modal.classList.toggle("hidden");
        }

        function addLinkField(button) {
            const linkContainer = button.closest('.space-y-4, #linkFields, #updateLinkFields');
            const linkGroups = linkContainer.querySelectorAll('.link-group');
            const linkCount = linkGroups.length + 1;

            if (linkCount > 5) {
                alert('You can add up to 5 links only.');
                return;
            }

            const linkGroup = document.createElement('div');
            linkGroup.className = 'link-group flex items-center space-x-2 mb-2';
            linkGroup.innerHTML = `  
            <div class="w-20 flex-shrink-0">
                <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Link ${linkCount}</span>
            </div>
            <div class="flex-grow">
                <input type="text" name="links[]" placeholder="Enter Link" required
                       class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-brand-500 focus:ring focus:ring-brand-200 dark:focus:ring-brand-800 dark:focus:border-brand-500 py-2 px-3">
            </div>
            <button type="button" onclick="removeLinkField(this)" 
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors">
                <i class="ri-delete-bin-6-fill"></i>
            </button>
        `;
            linkContainer.appendChild(linkGroup);
            renumberLinks(linkContainer);
        }

        function removeLinkField(button) {
            const linkContainer = button.closest('.space-y-4, #linkFields, #updateLinkFields');
            const linkGroups = linkContainer.querySelectorAll('.link-group');

            if (linkGroups.length > 1) {
                button.closest('.link-group').remove();
                renumberLinks(linkContainer);
            }
        }

        function renumberLinks(container) {
            const linkGroups = container.querySelectorAll('.link-group');
            linkGroups.forEach((group, index) => {
                const label = group.querySelector('.w-20 span');
                label.textContent = `Link ${index + 1}`;
            });
        }

        function populateUpdateModal(button) {
            const postId = button.getAttribute("data-id");
            const modal = document.getElementById("updatemodal");
            const titleField = document.getElementById("oldtitle");
            const linkContainer = document.getElementById("updateLinkFields");
            const idField = document.getElementById("postId");

            // Clear existing link fields except first one
            linkContainer.querySelectorAll('.link-group').forEach((group, index) => {
                if (index !== 0) group.remove();
            });

            // Fetch post data from server
            fetch(`/pfp/fetch/${postId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate title and ID
                    titleField.value = data.title;
                    idField.value = postId;

                    // Populate link fields
                    data.links.forEach((link, index) => {
                        if (index === 0) {
                            linkContainer.querySelector('input').value = link;
                        } else {
                            addLinkField(linkContainer.querySelector('button'));
                            linkContainer.querySelectorAll('input')[index].value = link;
                        }
                    });

                    // Show the modal
                    modal.classList.toggle("hidden");
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading post data');
                });
        }

        function copyPromotionalText(button) {
            const title = button.getAttribute("data-title");
            const slug = button.getAttribute("data-slug");
            const postUrl = `${window.location.origin}/p/${slug}`;
            const text = `${title} ⚡️ 

⚠️ @NxWall ⚠️ 

🔸Download Matching PFP Now🔸
👉 ${postUrl}

🔸 Click Link To Support Us🔸
👉 https://kutt.it/supportus

✅ Backup Channel
@NxWall`;
            navigator.clipboard.writeText(text).then(() => {
                // Create a temporary element to show success message
                const successMessage = document.createElement('div');
                successMessage.className =
                    'fixed top-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md z-50';
                successMessage.innerHTML =
                    '<div class="flex items-center"><i class="ri-checkbox-circle-line mr-2 text-xl"></i><span>Successfully Copied to Clipboard!</span></div>';
                document.body.appendChild(successMessage);

                // Remove the message after 2 seconds
                setTimeout(() => {
                    successMessage.remove();
                }, 2000);
            }).catch(error => {
                console.error('Error:', error);
                alert('Failed to copy to clipboard');
            });
        }

        // Autofocus search input if there's a search query
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("searchInput");
            if (searchInput.value.trim() !== "") {
                searchInput.focus();
            }
        });
    </script>
@endsection
