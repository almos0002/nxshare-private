@extends('layouts.app') @section('title', 'Nxleak') @section('content')

<!-- Wallpaper Stats -->
<div class="stats-container">
  <div class="stat-card">
      <div class="stat-header">
          <div class="stat-icon">
              <i class="ri-file-text-line"></i>
          </div>
          <div class="stat-content">
              <h3>Total Posts</h3>
              <p>{{ number_format($totalPosts) }}</p>
          </div>
      </div>
  </div>

  <div class="stat-card">
      <div class="stat-header">
          <div class="stat-icon" style="background: var(--secondary)">
              <i class="ri-eye-line"></i>
          </div>
          <div class="stat-content">
              <h3>Total Views</h3>
              <p>{{ number_format($totalViews) }}</p>
          </div>
      </div>
  </div>

  <div class="stat-card">
      <div class="stat-header">
          <div class="stat-icon" style="background: #10B981">
              <i class="ri-user-3-line"></i>
          </div>
          <div class="stat-content">
              <h3>Logged In User</h3>
              <p>{{ $userName }}</p>
          </div>
      </div>
  </div>

  <div class="stat-card">
      <div class="stat-header">
          <div class="stat-icon" style="background: #F59E0B">
              <i class="ri-shield-check-line"></i>
          </div>
          <div class="stat-content">
              <h3>Redirect Status</h3>
              <p>{{ $redirectEnabled }}</p>
          </div>
      </div>
  </div>
</div>

<!-- Add Post Button and Search -->
<div style="display:flex; justify-content:space-between;gap:8px;">
  <div>
     <form class="topbar-search" style="display: flex; gap: 5px;" action="{{ route('addnx') }}" method="GET">
        <input type="text" id="searchInput" class="form-control" placeholder="Search posts..." name="search" value="{{ request('search') }}">
        <span class="topbar-search-icon">
        <i class="ri-search-line"></i>
        </span>
        <button type="submit" class="btn btn-primary"><i class="ri-search-line"></i></button>
     </form>
  </div>
  <div style="display: flex;gap:4px">
     <button class="btn btn-primary" onClick="window.location.href = window.location.pathname;">Dashboard</button>
     <button class="btn btn-success" onclick="createModal()"><i class="ri-add-circle-fill"></i>&#160;Add</button>
  </div>
</div>
<!-- Create Post Modal -->
<div id="createmodal" class="hidden">
  <div class="modal-backdrop" onclick="createModal()"></div>
  <div class="modal">
    <div class="modal-content">
      <h3>Add New Post</h3>
      <br>
      <form id="postForm" method="post" action="{{ route('createnx') }}"> @csrf <div class="form-group">
          <label for="title" class="auth-label">Title</label>
          <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" required>
        </div>
        <div class="form-group">
          <label for="content" class="auth-label">Content</label>
          <textarea id="content" name="content" class="form-control" style="width: 100%; height: 200px; resize:none; padding:10px;" placeholder="Enter content" required>LINK

<- OR->
            
{MEGA.NZ_}[LINK]</textarea>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-light" onclick="createModal()">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Update Post Modal -->
<div id="updatemodal" class="hidden">
  <div class="modal-backdrop" onclick="updateModal()"></div>
  <div class="modal">
    <div class="modal-content">
      <h3>Update Post</h3>
      <br>
      <form id="postForm" method="post" action="{{ route('updatenx') }}"> @csrf <input type="hidden" id="postId" name="id">
        <div class="form-group">
          <label for="title" class="auth-label">Title</label>
          <input type="text" name="title" id="oldtitle" class="form-control" placeholder="Enter title" required>
        </div>
        <div class="form-group">
          <label for="content" class="auth-label">Content</label>
          <textarea id="oldcontent" name="content" class="form-control" style="width: 100%; height: 200px; resize:none; padding:10px;" placeholder="Enter content" required></textarea>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-light" onclick="updateModal()">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Posts Table -->
<div class="table-container">
  <table class="table">
    <thead>
      <tr>
        <th style="width:10%; text-align:center;">SN</th>
        <th style="width:55%;">Title</th>
        <th style="width:10%; text-align:center;">Views</th>
        <th style="width:10%; text-align:center;">Slug</th>
        <th style="width:15%; text-align:center;">Actions</th>
      </tr>
    </thead> @if(count($posts)) <tbody id="postTableBody"> @foreach($posts as $index => $post) <tr class="post-item">
        <td style="text-align:center;">{{ $posts->firstItem() + $index }}</td>
        <td class="post-title">{{ $post->title }}</td>
        <td style="text-align:center;">{{ $post->views }}</td>
        <td style="text-align:center;">{{ $post->slug }}</td>
        <td>
          <div style="display:flex;align-items:center;justify-content:center;">
            <a href="{{ route('displaynx', $post->slug) }}" class="dropdown-notification-item-icon primary-soft" style="text-decoration:none;">
              <i class="ri-eye-fill"></i>
            </a>
            <button class="dropdown-notification-item-icon success-soft" 
                     style="border: none; cursor: pointer;" 
                     data-id="{{ $post->id }}" 
                     onclick="populateUpdateModal(this)">
                  <i class="ri-pencil-fill"></i>
            </button>
            <a href="{{ route('deletenx', $post->slug) }}" class="dropdown-notification-item-icon danger-soft" style="text-decoration:none; margin-right:0px !important;" onclick="return confirm('Are you sure you want to delete this post?')">
              <i class="ri-delete-bin-fill"></i>
            </a>
          </div>
        </td>
      </tr> @endforeach </tbody> @else <tr>
      <td colspan="5" style="text-align:center;">No posts available.</td>
    </tr> @endif
  </table>
  <!-- Pagination -->
  <div class="pagination">
    {{ $posts->appends(request()->except('page'))->links('pagination::default') }}
  </div>
</div> @endsection @section('updatescript') <script>
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
    const contentField = document.getElementById("oldcontent");
    const idField = document.getElementById("postId");

    // Clear existing content (if needed)
    titleField.value = "";
    contentField.value = "";

    // Fetch post data from server
    fetch(`/nxleak/fetch/${postId}`)
        .then(response => response.json())
        .then(data => {
            // Populate title, content, and ID
            titleField.value = data.title;
            contentField.value = data.content;
            idField.value = postId;

            // Show the modal
            modal.classList.toggle("hidden");
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading post data');
        });
}
  // Autofocus search input if there's a search query
  document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");
    if (searchInput.value.trim() !== "") {
      searchInput.focus();
    }
  });
</script> @endsection