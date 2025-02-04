@extends('layouts.app') @section('title', 'Wallpapers') @section('content')
<!-- Add Post Button and Search -->
<div style="display:flex; justify-content:space-between;gap:8px;">
   <div>
      <form class="topbar-search" style="display: flex; gap: 5px;" action="{{ route('addwp') }}" method="GET">
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
         <form id="postForm" method="post" action="{{ route('createwp') }}">
            @csrf 
            <div class="form-group">
               <label for="title" class="auth-label">Title</label>
               <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" required>
            </div>
            <div class="form-group" id="linkFields">
               <div style="display:flex; justify-content:space-between; align-items:center">
                  <label for="link" class="auth-label" style="margin-bottom: 0px !important">Links</label>
                  <button type="button" class="btn btn-success" onclick="addLinkField(this)"><i class="ri-add-circle-fill"></i>&#160;Add Link</button>
               </div>
               <div class="link-group dflex">
                  <label class="auth-label" style="margin-top:9px; font-weight:bold">Link 1</label>&#160;
                  <input type="text" name="links[]" class="form-control form-control-flex" placeholder="Enter Link" required>
                  <button type="button" class="btn btn-danger" onclick="removeLinkField(this)"><i class="ri-delete-bin-6-fill"></i></button>
               </div>
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
         <form id="updateForm" method="post" action="{{ route('updatewp') }}">
            @csrf <input type="hidden" id="postId" name="id">
            <div class="form-group">
               <label for="oldtitle" class="auth-label">Title</label>
               <input type="text" name="title" id="oldtitle" class="form-control" placeholder="Enter title" required>
            </div>
            <div class="form-group" id="updateLinkFields">
               <div style="display:flex; justify-content:space-between; align-items:center">
                  <label for="oldlink" class="auth-label">Links</label>
                  <button type="button" class="btn btn-success" onclick="addLinkField(this)"><i class="ri-add-circle-fill"></i>&#160;Add Link</button>
               </div>
               <div class="link-group dflex">
                  <label class="auth-label" style="margin-top:9px; font-weight:bold">Link 1</label>&#160;
                  <input type="text" name="links[]" class="form-control form-control-flex" placeholder="Enter Link" required>
                  <button type="button" class="btn btn-danger" onclick="removeLinkField(this)"><i class="ri-delete-bin-6-fill"></i></button>
               </div>
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
      </thead>
      @if(count($posts)) 
      <tbody id="postTableBody">
         @foreach($posts as $index => $post) 
         <tr class="post-item">
            <td style="text-align:center;">{{ $index + 1 }}</td>
            <td class="post-title">{{ $post->title }}</td>
            <td style="text-align:center;">{{ $post->views }}</td>
            <td style="text-align:center;">{{ $post->slug }}</td>
            <td>
               <div style="display:flex;align-items:center;justify-content:center">
                  <a href="{{ route('displaywp', $post->slug) }}" class="dropdown-notification-item-icon primary-soft" style="text-decoration:none;">
                  <i class="ri-eye-fill"></i>
                  </a>
                  <button class="dropdown-notification-item-icon success-soft" 
                     style="border: none; cursor: pointer;" 
                     data-id="{{ $post->id }}" 
                     onclick="populateUpdateModal(this)">
                  <i class="ri-pencil-fill"></i>
                  </button>
                  <a href="{{ route('deletewp', $post->slug) }}" class="dropdown-notification-item-icon danger-soft" style="text-decoration:none; margin-right:0px !important;" onclick="return confirm('Are you sure you want to delete this post?')">
                  <i class="ri-delete-bin-fill"></i>
                  </a>
               </div>
            </td>
         </tr>
         @endforeach 
      </tbody>
      @else 
      <tr>
         <td colspan="5" style="text-align:center;">No posts available.</td>
      </tr>
      @endif
   </table>
   <!-- Pagination -->
   <div class="pagination">
      {{ $posts->appends(request()->except('page'))->links('pagination::default') }}
   </div>
</div>
@endsection @section('updatescript') <script>
   function createModal() {
     const modal = document.getElementById("createmodal");
     modal.classList.toggle("hidden");
   }
   
   function updateModal() {
     const modal = document.getElementById("updatemodal");
     modal.classList.toggle("hidden");
   }
   
   function addLinkField(button) {
   const linkContainer = button.closest('.form-group');
   const linkFields = linkContainer.querySelectorAll('.link-group');
   const linkCount = linkFields.length + 1;
   
   if (linkCount > 5) {
     alert('You can add up to 5 links only.');
     return;
   }
   
   const linkGroup = document.createElement('div');
   linkGroup.className = 'link-group dflex';
   linkGroup.innerHTML = `  
     <label class="auth-label" style="margin-top:9px; font-weight:bold">Link ${linkCount}</label>&#160;
     <input type="text" name="links[]" class="form-control form-control-flex" placeholder="Enter Link" required>
     <button type="button" class="btn btn-danger" onclick="removeLinkField(this)"><i class="ri-delete-bin-6-fill"></i></button>
   `;
   linkContainer.appendChild(linkGroup);
   renumberLinks(linkContainer); 
   }
   
   function removeLinkField(button) {
   const linkContainer = button.closest('.form-group');
   const linkFields = linkContainer.querySelectorAll('.link-group');
   
   if (linkFields.length > 1) {
     button.parentElement.remove();
     renumberLinks(linkContainer); 
   }
   }
   
   function renumberLinks(linkContainer) {
   const linkFields = linkContainer.querySelectorAll('.link-group');
   linkFields.forEach((field, index) => {
     const label = field.querySelector('label');
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
         fetch(`/wallpaper/fetch/${postId}`)
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
   // Autofocus search input if there's a search query
   document.addEventListener("DOMContentLoaded", () => {
     const searchInput = document.getElementById("searchInput");
     if (searchInput.value.trim() !== "") {
       searchInput.focus();
     }
   });
</script> @endsection