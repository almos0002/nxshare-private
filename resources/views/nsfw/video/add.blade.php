@extends('layouts.app')
@section('title', 'NSFW Videos')
@section('content')
    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 to-pink-600 text-white shadow-lg">
            <div class="absolute inset-0 bg-pattern opacity-10"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(255,255,255,0.5)\'/%3E%3C/svg%3E');">
            </div>
            <div class="relative px-6 py-8 md:px-8 md:py-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl font-bold">NSFW Videos Management</h1>
                        <p class="mt-1 text-red-100">Add, edit and manage your NSFW video collection</p>
                    </div>
                    <div>
                        <button onclick="createModal()"
                            class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-red-600 shadow-sm hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all">
                            <i class="ri-add-line mr-1.5"></i>
                            Add New Video
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
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Total Videos</p>
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">
                            {{ number_format($totalPosts) }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-400">
                        <i class="ri-video-line text-2xl"></i>
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
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 to-pink-500 opacity-0 transition-opacity group-hover:opacity-100">
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
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-pink-100 text-pink-600 dark:bg-pink-900/50 dark:text-pink-400">
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
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-pink-500 to-red-500 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>

            <!-- Logged In User -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Logged In User</p>
                        <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ Auth::user()->name }}</h3>
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
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-indigo-500 opacity-0 transition-opacity group-hover:opacity-100">
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
                        class="inline-flex items-center rounded-full bg-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-100 px-2.5 py-1 text-xs font-medium text-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-800 dark:bg-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-900/30 dark:text-{{ $redirectEnabled === 'Enabled' ? 'green' : 'red' }}-400">
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
                <form action="{{ route('addvd') }}" method="GET" class="flex">
                    <div class="relative w-full sm:w-80">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="ri-search-line text-surface-400 dark:text-surface-500"></i>
                        </span>
                        <input type="text" id="searchInput" placeholder="Search videos..." name="search"
                            value="{{ request('search') }}"
                            class="py-2 pl-10 pr-4 w-full rounded-lg bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500">
                    </div>
                    <button type="submit"
                        class="ml-2 inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors">
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
                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors">
                    <i class="ri-add-line mr-1"></i>
                    Add Video
                </button>
            </div>
        </div>

        <!-- Posts Table -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
            <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700 flex items-center justify-between">
                <h2 class="text-lg font-medium text-surface-900 dark:text-white">All Videos</h2>
                <span
                    class="inline-flex items-center rounded-full bg-surface-100 px-2.5 py-1 text-xs font-medium text-surface-800 dark:bg-surface-700 dark:text-surface-300">
                    {{ $posts->total() }} total
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
                                class="whitespace-nowrap px-4 py-3.5 text-center w-24 text-sm font-medium text-surface-500 dark:text-surface-400">
                                Thumbnail</th>
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
                                    <td class="whitespace-nowrap px-4 py-3.5 text-center">
                                        <img src="{{ $post->thumbnail }}" alt="thumbnail"
                                            class="h-12 w-20 object-cover rounded-md inline-block">
                                    </td>
                                    <td class="px-4 py-3.5 text-sm font-medium text-surface-900 dark:text-white">
                                        <div class="flex items-center">
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
                                            class="inline-flex items-center rounded-full bg-pink-50 px-2.5 py-1 text-xs font-medium text-pink-700 dark:bg-pink-900/30 dark:text-pink-400">
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
                                            <a href="{{ route('displayvd', $post->slug) }}"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 hover:bg-violet-200 dark:hover:bg-violet-800/50 transition-colors"
                                                title="View">
                                                <i class="ri-eye-fill"></i>
                                            </a>
                                            <button data-id="{{ $post->id }}" onclick="populateUpdateModal(this)"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-fuchsia-100 dark:bg-fuchsia-900/30 text-fuchsia-600 dark:text-fuchsia-400 hover:bg-fuchsia-200 dark:hover:bg-fuchsia-800/50 transition-colors"
                                                title="Edit">
                                                <i class="ri-edit-fill"></i>
                                            </button>
                                            <a href="{{ route('deletevd', $post->slug) }}"
                                                onclick="return confirm('Are you sure you want to delete this post?')"
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-200 dark:hover:bg-rose-800/50 transition-colors"
                                                title="Delete">
                                                <i class="ri-delete-bin-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6"
                                    class="px-4 py-8 text-center text-sm text-surface-500 dark:text-surface-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="h-12 w-12 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center text-surface-400 dark:text-surface-500 mb-3">
                                            <i class="ri-inbox-line text-2xl"></i>
                                        </div>
                                        <p class="text-surface-900 dark:text-white font-medium">No NSFW videos found</p>
                                        <p class="text-surface-500 dark:text-surface-400 text-sm mt-1">Start by adding a
                                            new NSFW video</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                class="px-4 py-3 flex items-center justify-between border-t border-surface-200 dark:border-surface-700 sm:px-6">
                <p class="text-sm text-surface-500 dark:text-surface-400">
                    Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} videos
                </p>
                <div>
                    {{ $posts->appends(request()->except('page'))->links('pagination::default') }}
                </div>
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
                            <h3 class="text-lg font-medium leading-6 text-surface-900 dark:text-white">Add New Video</h3>
                            <button type="button" onclick="createModal()"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200">
                                <i class="ri-close-line text-xl"></i>
                            </button>
                        </div>

                        <form id="postForm" method="post" action="{{ route('createvd') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="title"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Title</label>
                                    <input type="text" name="title" id="title" placeholder="Enter title"
                                        required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                                </div>

                                <div>
                                    <label for="thumbnail"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Thumbnail
                                        URL</label>
                                    <input type="text" name="thumbnail" id="thumbnail"
                                        placeholder="Enter thumbnail link" required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                                </div>

                                <div>
                                    <label for="link"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Video
                                        Link</label>
                                    <input type="text" name="links" id="link" placeholder="Enter video link"
                                        required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="createModal()"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-600 font-medium transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors">
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
                            <h3 class="text-lg font-medium leading-6 text-surface-900 dark:text-white">Update Video</h3>
                            <button type="button" onclick="updateModal()"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200">
                                <i class="ri-close-line text-xl"></i>
                            </button>
                        </div>

                        <form id="updateForm" method="post" action="{{ route('updatevd') }}">
                            @csrf
                            <input type="hidden" id="postId" name="id">
                            <div class="space-y-4">
                                <div>
                                    <label for="oldtitle"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Title</label>
                                    <input type="text" name="title" id="oldtitle" placeholder="Enter title"
                                        required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                                </div>

                                <div>
                                    <label for="oldthumbnail"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Thumbnail
                                        URL</label>
                                    <input type="text" name="thumbnail" id="oldthumbnail"
                                        placeholder="Enter thumbnail link" required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                                </div>

                                <div>
                                    <label for="oldlinks"
                                        class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Video
                                        Link</label>
                                    <input type="text" name="links" id="oldlinks" placeholder="Enter video link"
                                        required
                                        class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="updateModal()"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-600 font-medium transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection @section('updatescript')
<script>
    function createModal() {
        const modal = document.getElementById("createmodal");
        modal.classList.toggle("hidden");
    }

    function updateModal() {
        const modal = document.getElementById("updatemodal");
        modal.classList.toggle("hidden");
    }

    function populateUpdateModal(button) {
        const postId = button.getAttribute("data-id");
        const modal = document.getElementById("updatemodal");
        const titleField = document.getElementById("oldtitle");
        const thumbnailField = document.getElementById("oldthumbnail");
        const linkField = document.getElementById("oldlinks");
        const idField = document.getElementById("postId");

        // Fetch post data from server
        fetch(`/videos/fetch/${postId}`)
            .then(response => response.json())
            .then(data => {
                // Populate title and ID
                titleField.value = data.title;
                idField.value = postId;
                thumbnailField.value = data.thumbnail;
                linkField.value = data.links;

                // Show the modal
                modal.classList.toggle("hidden");
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading post data');
            });
    }
</script> @endsection
