@extends('layouts.app') 
@section('title', 'NSFW Images') 
@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-red-600 to-pink-600 text-white shadow-lg">
        <div class="absolute inset-0 bg-pattern opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(255,255,255,0.5)\'/%3E%3C/svg%3E');"></div>
        <div class="relative px-6 py-8 md:px-8 md:py-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold">NSFW Images Management</h1>
                    <p class="mt-1 text-red-100">Add, edit and manage your NSFW image collection</p>
                </div>
                <div>
                    <button onclick="createModal()" class="inline-flex items-center rounded-lg bg-white px-4 py-2 text-sm font-medium text-red-600 shadow-sm hover:bg-white/90 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all">
                        <i class="ri-add-line mr-1.5"></i>
                        Add New Image
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Posts -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-md transition-all hover:shadow-lg dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Total Posts</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ number_format($totalPosts) }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400">
                    <i class="ri-file-list-3-line text-2xl"></i>
                </div>
            </div>
            <div class="mt-5 flex items-center">
                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                    <i class="ri-arrow-up-line mr-1"></i> 12%
                </span>
                <span class="ml-2 text-surface-500 dark:text-surface-400">from last month</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-indigo-500 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>

        <!-- Total Views -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-md transition-all hover:shadow-lg dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Total Views</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ number_format($totalViews) }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400">
                    <i class="ri-eye-line text-2xl"></i>
                </div>
            </div>
            <div class="mt-5 flex items-center">
                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                    <i class="ri-arrow-up-line mr-1"></i> 24%
                </span>
                <span class="ml-2 text-surface-500 dark:text-surface-400">from last month</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-rose-500 to-pink-500 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>

        <!-- Logged In User -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-md transition-all hover:shadow-lg dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Logged In User</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ Auth::user()->name }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-fuchsia-100 text-fuchsia-600 dark:bg-fuchsia-900/30 dark:text-fuchsia-400">
                    <i class="ri-user-3-line text-2xl"></i>
                </div>
            </div>
            <div class="mt-5 flex items-center">
                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                    <i class="ri-arrow-up-line mr-1"></i> 8%
                </span>
                <span class="ml-2 text-surface-500 dark:text-surface-400">from last week</span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-fuchsia-500 to-purple-500 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>

        <!-- Redirect Status -->
        <div class="group relative overflow-hidden rounded-xl bg-white p-5 shadow-md transition-all hover:shadow-lg dark:bg-surface-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Redirect Status</p>
                    <h3 class="mt-1 text-3xl font-bold text-surface-900 dark:text-white">{{ $redirectEnabled }}</h3>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                    <i class="ri-link text-2xl"></i>
                </div>
            </div>
            <div class="mt-5 flex items-center">
                <span class="inline-flex items-center {{ $redirectEnabled === 'Enabled' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $redirectEnabled === 'Enabled' ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 opacity-0 transition-opacity group-hover:opacity-100"></div>
        </div>
    </div>

    <!-- Search and Action Buttons -->
    <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
        <div class="w-full sm:w-auto">
            <form class="flex" action="{{ route('addimg') }}" method="GET">
                <div class="relative flex-grow">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="ri-search-line text-surface-400 dark:text-surface-500"></i>
                    </span>
                    <input type="text" id="searchInput" placeholder="Search posts..." name="search" value="{{ request('search') }}" 
                           class="py-2 pl-10 pr-4 w-full rounded-lg bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500">
                </div>
                <button type="submit" class="ml-2 inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors">
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
                Add Image
            </button>
        </div>
    </div>

    <!-- Posts Table -->
    <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
        <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-surface-900 dark:text-white">NSFW Images</h2>
            <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 dark:bg-red-900/30 dark:text-red-400">
                {{ count($posts) }} posts
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-50 dark:bg-surface-700/50 border-b border-surface-200 dark:border-surface-700">
                        <th class="whitespace-nowrap px-4 py-3.5 text-center w-16 text-sm font-medium text-surface-500 dark:text-surface-400">SN</th>
                        <th class="whitespace-nowrap px-4 py-3.5 text-left text-sm font-medium text-surface-500 dark:text-surface-400">Title</th>
                        <th class="whitespace-nowrap px-4 py-3.5 text-center w-24 text-sm font-medium text-surface-500 dark:text-surface-400">Views</th>
                        <th class="whitespace-nowrap px-4 py-3.5 text-center w-24 text-sm font-medium text-surface-500 dark:text-surface-400">Slug</th>
                        <th class="whitespace-nowrap px-4 py-3.5 text-center w-32 text-sm font-medium text-surface-500 dark:text-surface-400">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                    @if(count($posts))
                        @foreach($posts as $index => $post)
                        <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                            <td class="whitespace-nowrap px-4 py-3.5 text-center text-sm text-surface-500 dark:text-surface-400 font-medium">{{ $posts->firstItem() + $index }}</td>
                            <td class="px-4 py-3.5 text-sm font-medium text-surface-900 dark:text-white">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 flex-shrink-0 rounded-md bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400 mr-3 font-bold">
                                        {{ substr($post->title, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-surface-900 dark:text-white">{{ $post->title }}</div>
                                        <div class="text-xs text-surface-500 dark:text-surface-400">Added {{ $post->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-center">
                                <span class="inline-flex items-center rounded-full bg-pink-50 px-2.5 py-1 text-xs font-medium text-pink-700 dark:bg-pink-900/30 dark:text-pink-400">
                                    <i class="ri-eye-line mr-1"></i> {{ number_format($post->views) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-center">
                                <span class="inline-flex items-center rounded-md bg-surface-100 px-2 py-1 text-xs font-medium text-surface-700 dark:bg-surface-700 dark:text-surface-300">
                                    {{ $post->slug }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('displayimg', $post->slug) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 hover:bg-violet-200 dark:hover:bg-violet-800/50 transition-colors" title="View">
                                        <i class="ri-eye-fill"></i>
                                    </a>
                                    <button data-id="{{ $post->id }}" onclick="populateUpdateModal(this)" 
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-fuchsia-100 dark:bg-fuchsia-900/30 text-fuchsia-600 dark:text-fuchsia-400 hover:bg-fuchsia-200 dark:hover:bg-fuchsia-800/50 transition-colors" title="Edit">
                                        <i class="ri-edit-fill"></i>
                                    </button>
                                    <a href="{{ route('deleteimg', $post->slug) }}" onclick="return confirm('Are you sure you want to delete this post?')" 
                                       class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-200 dark:hover:bg-rose-800/50 transition-colors" title="Delete">
                                        <i class="ri-delete-bin-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-surface-500 dark:text-surface-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="ri-inbox-line text-4xl mb-2 text-surface-400 dark:text-surface-500"></i>
                                    <p class="text-surface-900 dark:text-white font-medium">No posts found</p>
                                    <p class="text-surface-500 dark:text-surface-400 mt-1">Get started by creating a new post</p>
                                    <button onclick="createModal()" class="mt-3 inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-colors">
                                        <i class="ri-add-line mr-1"></i>
                                        Add New Image
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="border-t border-surface-200 bg-surface-50 px-6 py-4 dark:border-surface-700 dark:bg-surface-800/80">
            <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                <p class="text-sm text-surface-500 dark:text-surface-400">
                    Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} posts
                </p>
                <div>
                    {{ $posts->appends(request()->except('page'))->links('pagination::default') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Post Modal -->
<div id="createmodal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
        <div class="fixed inset-0 bg-surface-900/75 backdrop-blur-sm transition-opacity" onclick="createModal()"></div>
        
        <div class="inline-block align-middle bg-white dark:bg-surface-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
            <div class="px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-surface-900 dark:text-white">Add New Image</h3>
                    <button type="button" onclick="createModal()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
                
                <form id="postForm" method="post" action="{{ route('createimg') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Title</label>
                            <input type="text" name="title" id="title" placeholder="Enter title" required
                                   class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                        </div>
                        
                        <div id="linkFields">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">Links</label>
                                <button type="button" onclick="addLinkField(this)" 
                                        class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-colors">
                                    <i class="ri-add-circle-fill mr-1"></i>
                                    Add Link
                                </button>
                            </div>
                            
                            <div class="link-group flex items-center space-x-2 mb-2">
                                <div class="w-20 flex-shrink-0">
                                    <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Link 1</span>
                                </div>
                                <div class="flex-grow">
                                    <input type="text" name="links[]" placeholder="Enter Link" required
                                           class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
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
        <div class="fixed inset-0 bg-surface-900/75 backdrop-blur-sm transition-opacity" onclick="updateModal()"></div>
        
        <div class="inline-block align-middle bg-white dark:bg-surface-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
            <div class="px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium leading-6 text-surface-900 dark:text-white">Update Image</h3>
                    <button type="button" onclick="updateModal()" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200">
                        <i class="ri-close-line text-xl"></i>
                    </button>
                </div>
                
                <form id="updateForm" method="post" action="{{ route('updateimg') }}">
                    @csrf
                    <input type="hidden" id="postId" name="id">
                    <div class="space-y-4">
                        <div>
                            <label for="oldtitle" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Title</label>
                            <input type="text" name="title" id="oldtitle" placeholder="Enter title" required
                                   class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
                        </div>
                        
                        <div id="updateLinkFields">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">Links</label>
                                <button type="button" onclick="addLinkField(this)" 
                                        class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition-colors">
                                    <i class="ri-add-circle-fill mr-1"></i>
                                    Add Link
                                </button>
                            </div>
                            
                            <div class="link-group flex items-center space-x-2 mb-2">
                                <div class="w-20 flex-shrink-0">
                                    <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Link 1</span>
                                </div>
                                <div class="flex-grow">
                                    <input type="text" name="links[]" placeholder="Enter Link" required
                                           class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
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
                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
@endsection
@section('updatescript') 
<script>
   // Toggle create modal visibility
   function createModal() {
     const modal = document.getElementById("createmodal");
     modal.classList.toggle("hidden");
   }
   
   // Toggle update modal visibility
   function updateModal() {
     const modal = document.getElementById("updatemodal");
     modal.classList.toggle("hidden");
   }
   
   // Add a new link field to either create or update modal
   function addLinkField(button) {
     // Find the container (either linkFields or updateLinkFields)
     const container = button.closest('div[id="linkFields"], div[id="updateLinkFields"]');
     if (!container) return;
     
     const linkGroups = container.querySelectorAll('.link-group');
     const linkCount = linkGroups.length + 1;
     
     // Limit to 5 links
     if (linkCount > 5) {
       alert('You can add up to 5 links only.');
       return;
     }
     
     // Create new link group
     const newLinkGroup = document.createElement('div');
     newLinkGroup.className = 'link-group flex items-center space-x-2 mb-2';
     
     // Set inner HTML for the new link group
     newLinkGroup.innerHTML = `
       <div class="w-20 flex-shrink-0">
         <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Link ${linkCount}</span>
       </div>
       <div class="flex-grow">
         <input type="text" name="links[]" placeholder="Enter Link" required
                class="w-full rounded-lg bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-700 focus:border-red-500 focus:ring focus:ring-red-200 dark:focus:ring-red-800 dark:focus:border-red-500 py-2 px-3">
       </div>
       <button type="button" onclick="removeLinkField(this)" 
               class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-800/50 transition-colors">
         <i class="ri-delete-bin-6-fill"></i>
       </button>
     `;
     
     // Append the new link group to the container
     container.appendChild(newLinkGroup);
     
     // Update link numbers
     renumberLinks(container);
   }
   
   // Remove a link field from either create or update modal
   function removeLinkField(button) {
     // Find the container (either linkFields or updateLinkFields)
     const container = button.closest('div[id="linkFields"], div[id="updateLinkFields"]');
     if (!container) return;
     
     const linkGroups = container.querySelectorAll('.link-group');
     
     // Don't remove if it's the only link field
     if (linkGroups.length > 1) {
       button.closest('.link-group').remove();
       renumberLinks(container);
     }
   }
   
   // Update the numbering of link fields
   function renumberLinks(container) {
     const linkGroups = container.querySelectorAll('.link-group');
     linkGroups.forEach((group, index) => {
       const label = group.querySelector('span');
       if (label) {
         label.textContent = `Link ${index + 1}`;
       }
     });
   }
   
   // Populate the update modal with post data
   function populateUpdateModal(button) {
     const postId = button.getAttribute("data-id");
     const modal = document.getElementById("updatemodal");
     const titleField = document.getElementById("oldtitle");
     const linkContainer = document.getElementById("updateLinkFields");
     const idField = document.getElementById("postId");
     
     // Clear existing link fields except the first one
     const linkGroups = linkContainer.querySelectorAll('.link-group');
     linkGroups.forEach((group, index) => {
       if (index !== 0) group.remove();
     });
     
     // Reset the first link field value
     const firstInput = linkContainer.querySelector('input[name="links[]"]');
     if (firstInput) firstInput.value = '';
     
     // Fetch post data
     fetch(`/images/fetch/${postId}`)
       .then(response => {
         if (!response.ok) {
           throw new Error('Network response was not ok');
         }
         return response.json();
       })
       .then(data => {
         // Populate title and ID
         titleField.value = data.title;
         idField.value = postId;
         
         // Populate link fields
         if (data.links && Array.isArray(data.links)) {
           data.links.forEach((link, index) => {
             if (index === 0) {
               // Set first link field
               const firstInput = linkContainer.querySelector('input[name="links[]"]');
               if (firstInput) firstInput.value = link;
             } else {
               // Add new link field and set its value
               const addButton = linkContainer.querySelector('button[onclick^="addLinkField"]');
               if (addButton) {
                 addLinkField(addButton);
                 const inputs = linkContainer.querySelectorAll('input[name="links[]"]');
                 if (inputs.length > index) {
                   inputs[index].value = link;
                 }
               }
             }
           });
         }
         
         // Show the modal
         modal.classList.remove("hidden");
       })
       .catch(error => {
         console.error('Error fetching post data:', error);
         alert('Failed to load post data. Please try again.');
       });
   }
   
   // Autofocus search input if there's a search query
   document.addEventListener("DOMContentLoaded", () => {
     const searchInput = document.getElementById("searchInput");
     if (searchInput && searchInput.value.trim() !== "") {
       searchInput.focus();
     }
   });
</script> 
@endsection