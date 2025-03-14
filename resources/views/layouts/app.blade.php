<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">
        <link href="{{asset('assets')}}/css/style.css" rel="stylesheet">
        <link href="{{asset('assets')}}/css/dashboard.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <title>@yield('title', 'Private Blog') - NxShare</title>
        <style>
            /* Custom styling for NSFW toggle button */
            #nsfw-toggle-btn {
                width: 32px !important;
                height: 32px !important;
                padding: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 50% !important; /* Make button perfectly circular */
                vertical-align: middle !important;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }
            #nsfw-toggle-btn.nsfw-enabled {
                background-color: #198754 !important;
                color: white !important;
            }
            #nsfw-toggle-btn.nsfw-disabled {
                background-color: #000000 !important;
                color: white !important;
            }
            #nsfw-toggle-icon {
                font-size: 18px !important;
            }
            
            /* Fix vertical alignment of topbar buttons */
            .topbar-right-item {
                vertical-align: middle !important;
                margin-top: auto !important;
                margin-bottom: auto !important;
            }
        </style>
    </head>
    <body>
        <!-- start: Sidebar -->
        <div class="sidebar">
            <a href="#" class="sidebar-brand">
                <img src="https://i.postimg.cc/4dbDJLpG/favicon.png" alt="" class="sidebar-brand-image" />
                <span class="sidebar-brand-text">NxShare</span>
            </a>
            <div class="sidebar-menu-wrapper">
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-title">
                        <span class="sidebar-menu-title-expanded">MENU</span>
                        <span class="sidebar-menu-title-collapsed"><i class="ri-more-fill"></i></span>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{route('dashboard')}}" class="sidebar-menu-item-link">
                            <span class="sidebar-menu-item-link-icon">
                                <i class="ri-dashboard-line"></i>
                            </span>
                            <span class="sidebar-menu-item-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item" data-sidebar-menu-item>
                        <a href="#" class="sidebar-menu-item-link" data-sidebar-menu-toggle>
                            <span class="sidebar-menu-item-link-icon">
                                <i class="ri-bubble-chart-line"></i>
                            </span>
                            <span class="sidebar-menu-item-link-text">SFW</span>
                            <span class="sidebar-menu-item-link-arrow">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                        </a>
                        <ul class="sidebar-submenu" data-sidebar-menu-dropdown>
                            <li class="sidebar-submenu-item">
                                <a href="{{route('addwp')}}" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Wallpaper</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item" data-sidebar-menu-item id="nsfw-menu-item" style="display: {{ Auth::check() && Auth::user()->settings && Auth::user()->settings->nsfw === 'enabled' ? 'list-item' : 'none' }};">
                        <a href="#" class="sidebar-menu-item-link" data-sidebar-menu-toggle>
                            <span class="sidebar-menu-item-link-icon">
                                <i class="ri-vip-line"></i>
                            </span>
                            <span class="sidebar-menu-item-link-text">NSF</span>
                            <span class="sidebar-menu-item-link-arrow">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                        </a>
                        <ul class="sidebar-submenu" data-sidebar-menu-dropdown>
                            <li class="sidebar-submenu-item">
                                <a href="{{route('addnx')}}" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Nxleak</span>
                                </a>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="{{route('addimg')}}" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Images</span>
                                </a>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="{{route('addvd')}}" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Videos</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-title">
                        <span class="sidebar-menu-title-expanded">OTHRES</span>
                        <span class="sidebar-menu-title-collapsed"><i class="ri-more-fill"></i></span>
                    </li>
                    <li class="sidebar-menu-item" data-sidebar-menu-item>
                        <a href="#" class="sidebar-menu-item-link" data-sidebar-menu-toggle>
                            <span class="sidebar-menu-item-link-icon">
                                <i class="ri-dashboard-3-line"></i>
                            </span>
                            <span class="sidebar-menu-item-link-text">Dashboard</span>
                            <span class="sidebar-menu-item-link-arrow">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                        </a>
                        <ul class="sidebar-submenu" data-sidebar-menu-dropdown>
                            <li class="sidebar-submenu-item" data-sidebar-submenu-item>
                                <a href="#" class="sidebar-submenu-item-link" data-sidebar-submenu-toggle>
                                    <span class="sidebar-submenu-item-link-text">Analytics</span>
                                    <span class="sidebar-submenu-item-link-arrow">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </span>
                                </a>
                                <ul class="sidebar-submenu" data-sidebar-submenu-dropdown>
                                    <li class="sidebar-submenu-item">
                                        <a href="#" class="sidebar-submenu-item-link">
                                            <span class="sidebar-submenu-item-link-text">Test</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="#" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Ecommerce</span>
                                </a>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="#" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">LMS</span>
                                </a>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="#" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Crypto</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item" data-sidebar-menu-item>
                        <a href="#" class="sidebar-menu-item-link" data-sidebar-menu-toggle>
                            <span class="sidebar-menu-item-link-icon">
                                <i class="ri-apps-2-line"></i>
                            </span>
                            <span class="sidebar-menu-item-link-text">Apps</span>
                            <span class="sidebar-menu-item-link-arrow">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                        </a>
                        <ul class="sidebar-submenu" data-sidebar-menu-dropdown>
                            <li class="sidebar-submenu-item" data-sidebar-submenu-item>
                                <a href="#" class="sidebar-submenu-item-link" data-sidebar-submenu-toggle>
                                    <span class="sidebar-submenu-item-link-text">Analytics</span>
                                    <span class="sidebar-submenu-item-link-arrow">
                                        <i class="ri-arrow-right-s-line"></i>
                                    </span>
                                </a>
                                <ul class="sidebar-submenu" data-sidebar-submenu-dropdown>
                                    <li class="sidebar-submenu-item" data-sidebar-submenu-item>
                                        <a href="#" class="sidebar-submenu-item-link" data-sidebar-submenu-toggle>
                                            <span class="sidebar-submenu-item-link-text">Test</span>
                                            <span class="sidebar-submenu-item-link-arrow">
                                                <i class="ri-arrow-right-s-line"></i>
                                            </span>
                                        </a>
                                        <ul class="sidebar-submenu" data-sidebar-submenu-dropdown>
                                            <li class="sidebar-submenu-item">
                                                <a href="#" class="sidebar-submenu-item-link">
                                                    <span class="sidebar-submenu-item-link-text">Test</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="#" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Ecommerce</span>
                                </a>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="#" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">LMS</span>
                                </a>
                            </li>
                            <li class="sidebar-submenu-item">
                                <a href="#" class="sidebar-submenu-item-link">
                                    <span class="sidebar-submenu-item-link-text">Crypto</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="#" class="sidebar-menu-item-link">
                            <span class="sidebar-menu-item-link-icon">
                                <i class="ri-dashboard-3-line"></i>
                            </span>
                            <span class="sidebar-menu-item-link-text">Link</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-overlay" data-sidebar-dismiss=""></div>
        <!-- end: Sidebar -->

        <!-- start: Main -->
        <div class="main">
            <div class="topbar">
                <button type="button" class="btn btn-icon btn-light topbar-sidebar-toggle" data-sidebar-toggle><i class="ri-menu-2-line"></i></button>
                <div class="topbar-search-wrapper">
                    <button type="button" class="btn btn-icon btn-light topbar-search-back" data-dismiss="topbar-search">
                        <i class="ri-arrow-left-line"></i>
                    </button>
                    <form class="topbar-search">
                        <input type="text" class="form-control" placeholder="Search..." />
                        <span class="topbar-search-icon"><i class="ri-search-line"></i></span>
                    </form>
                </div>
                <div class="topbar-right">
                    <button type="button" class="btn btn-icon btn-light topbar-right-item-search" data-toggle="topbar-search">
                        <i class="ri-search-line"></i>
                    </button>

                <!-- Top Bar Disabled -->
                
                    {{-- <div class="dropdown">
                        <button type="button" class="btn btn-icon btn-light topbar-right-item" data-toggle="dropdown">
                            <img src="https://flagsapi.com/US/shiny/64.png" class="topbar-right-item-image" />
                        </button>
                        <div class="dropdown-menu-wrapper">
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu-item">
                                    <a href="#" class="dropdown-menu-item-link">
                                        <img src="https://flagsapi.com/BD/shiny/64.png" class="dropdown-menu-item-link-image" />
                                        <span class="dropdown-menu-item-link-text">Bangladesh</span>
                                    </a>
                                </li>
                                <li class="dropdown-menu-item">
                                    <a href="#" class="dropdown-menu-item-link">
                                        <img src="https://flagsapi.com/ID/shiny/64.png" class="dropdown-menu-item-link-image" />
                                        <span class="dropdown-menu-item-link-text">Indonesia</span>
                                    </a>
                                </li>
                                <li class="dropdown-menu-item">
                                    <a href="#" class="dropdown-menu-item-link">
                                        <img src="https://flagsapi.com/SG/shiny/64.png" class="dropdown-menu-item-link-image" />
                                        <span class="dropdown-menu-item-link-text">Singapore</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-icon btn-light topbar-right-item" data-toggle="dropdown">
                            <i class="ri-shopping-cart-2-line"></i>
                            <span class="topbar-right-item-total">5</span>
                        </button>
                        <div class="dropdown-menu-wrapper">
                            <div class="dropdown-content">
                                <div class="dropdown-content-header">
                                    <p class="dropdown-content-title">Cart</p>
                                    <span class="badge badge-primary-soft">5 items</span>
                                </div>
                                <div class="dropdown-content-body">
                                    <div class="dropdown-cart-wrapper">
                                        <div class="dropdown-cart-item">
                                            <img src="https://placehold.co/100x100" alt="" class="dropdown-cart-item-image" />
                                            <div class="dropdown-cart-item-body">
                                                <a href="#" class="dropdown-cart-item-title">Lorem ipsum dolor sit amet consectetur adipisicing.</a>
                                                <p class="dropdown-cart-item-description">Qty: 1 * &dollar;10</p>
                                            </div>
                                            <p class="dropdown-cart-item-price">&dollar;10</p>
                                            <button type="button" class="dropdown-cart-item-remove"><i class="ri-delete-bin-line"></i></button>
                                        </div>
                                        <div class="dropdown-cart-item">
                                            <img src="https://placehold.co/100x100" alt="" class="dropdown-cart-item-image" />
                                            <div class="dropdown-cart-item-body">
                                                <a href="#" class="dropdown-cart-item-title">Lorem ipsum dolor sit amet consectetur adipisicing.</a>
                                                <p class="dropdown-cart-item-description">Qty: 1 * &dollar;10</p>
                                            </div>
                                            <p class="dropdown-cart-item-price">&dollar;10</p>
                                            <button type="button" class="dropdown-cart-item-remove"><i class="ri-delete-bin-line"></i></button>
                                        </div>
                                        <div class="dropdown-cart-item">
                                            <img src="https://placehold.co/100x100" alt="" class="dropdown-cart-item-image" />
                                            <div class="dropdown-cart-item-body">
                                                <a href="#" class="dropdown-cart-item-title">Lorem ipsum dolor sit amet consectetur adipisicing.</a>
                                                <p class="dropdown-cart-item-description">Qty: 1 * &dollar;10</p>
                                            </div>
                                            <p class="dropdown-cart-item-price">&dollar;10</p>
                                            <button type="button" class="dropdown-cart-item-remove"><i class="ri-delete-bin-line"></i></button>
                                        </div>
                                    </div>
                                    <div class="dropdown-content-bottom">
                                        <div class="dropdown-cart-total">
                                            <p class="dropdown-cart-total-text">Total</p>
                                            <p class="dropdown-cart-total-amount">&dollar;30</p>
                                        </div>
                                        <a href="#" class="btn btn-primary btn-block">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button type="button" class="btn btn-icon btn-light topbar-right-item" data-toggle="dropdown">
                            <i class="ri-notification-3-line"></i>
                            <span class="topbar-right-item-total">4</span>
                        </button>
                        <div class="dropdown-menu-wrapper">
                            <div class="dropdown-content">
                                <div class="dropdown-content-header">
                                    <p class="dropdown-content-title">Notification</p>
                                    <span class="badge badge-primary-soft">7 items</span>
                                </div>
                                <div class="dropdown-content-body">
                                    <div class="dropdown-notification-wrapper">
                                        <a href="#" class="dropdown-notification-item">
                                            <span class="dropdown-notification-item-icon primary-soft">
                                                <i class="ri-history-line"></i>
                                            </span>
                                            <p class="dropdown-notification-item-title">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                            <p class="dropdown-notification-item-time">4 days ago</p>
                                        </a>
                                        <a href="#" class="dropdown-notification-item">
                                            <span class="dropdown-notification-item-icon danger-soft">
                                                <i class="ri-history-line"></i>
                                            </span>
                                            <p class="dropdown-notification-item-title">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                            <p class="dropdown-notification-item-time">4 days ago</p>
                                        </a>
                                        <a href="#" class="dropdown-notification-item">
                                            <span class="dropdown-notification-item-icon success-soft">
                                                <i class="ri-history-line"></i>
                                            </span>
                                            <p class="dropdown-notification-item-title">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                            <p class="dropdown-notification-item-time">4 days ago</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    @if(Auth::check())
                        <button id="nsfw-toggle-btn" type="button" 
                            class="btn btn-icon topbar-right-item {{ Auth::user()->settings && Auth::user()->settings->nsfw == 'enabled' ? 'nsfw-enabled' : 'nsfw-disabled' }}"
                            data-status="{{ Auth::user()->settings && Auth::user()->settings->nsfw == 'enabled' ? 'enabled' : 'disabled' }}"
                            onclick="toggleNsfw()">
                            <i id="nsfw-toggle-icon" class="{{ Auth::user()->settings && Auth::user()->settings->nsfw == 'enabled' ? 'ri-shield-check-fill' : 'ri-shield-flash-line' }}"></i>
                        </button>
                    @endif

                    <div class="dropdown">
                        <button type="button" class="btn btn-icon btn-light topbar-right-item" data-toggle="dropdown">
                            <img src="https://i.postimg.cc/JhnVsqv9/fire.png" alt="" class="topbar-right-item-user-image" />
                        </button>
                        <div class="dropdown-menu-wrapper">
                            <ul class="dropdown-menu">
                                <li class="dropdown-menu-item">
                                    <a href="{{route('profile.update')}}" class="dropdown-menu-item-link">
                                        <span class="dropdown-menu-item-link-icon"><i class="ri-user-line"></i></span>
                                        <span class="dropdown-menu-item-link-text">Profile</span>
                                    </a>
                                </li>
                                <li class="dropdown-menu-item">
                                    <a href="{{route('settings.update')}}" class="dropdown-menu-item-link">
                                        <span class="dropdown-menu-item-link-icon"><i class="ri-settings-line"></i></span>
                                        <span class="dropdown-menu-item-link-text">Settings</span>
                                    </a>
                                </li>
                                <li class="dropdown-menu-item">
                                    <a href="" class="dropdown-menu-item-link"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        <span class="dropdown-menu-item-link-icon"><i class="ri-logout-circle-line"></i></span>
                                        <span class="dropdown-menu-item-link-text">Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                @yield('content')
            </div>
        </div>
        <!-- end: Main -->

        <script src="https://cdn.jsdelivr.net/npm/@floating-ui/core@1.6.8"></script>
        <script src="https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.12"></script>
        <script src="{{asset('assets')}}/js/script.js"></script>
        
        <script>
            // Immediate execution on page load - before document ready
            (function() {
                console.log('Immediate script execution - checking NSFW menu');
                const nsfw_menu = document.getElementById('nsfw-menu-item');
                const toggle_btn = document.getElementById('nsfw-toggle-btn');
                
                if (nsfw_menu && toggle_btn) {
                    console.log('Found both menu and button elements');
                    const status = toggle_btn.getAttribute('data-status');
                    console.log('Initial NSFW status (direct DOM):', status);
                    
                    // Force correct initial state
                    if (status === 'disabled') {
                        nsfw_menu.style.display = 'none';
                        console.log('Force setting menu to hidden');
                    } else {
                        nsfw_menu.style.display = 'list-item';
                        console.log('Force setting menu to visible');
                    }
                } else {
                    console.error('Elements not found - Menu:', nsfw_menu, 'Button:', toggle_btn);
                }
            })();
            
            // Initialize NSFW elements on page load
            $(document).ready(function() {
                console.log('Document ready - initializing NSFW elements');
                
                const button = $('#nsfw-toggle-btn');
                if (button.length > 0) {
                    // Force read from attribute, not from jQuery cache
                    const currentStatus = button.attr('data-status');
                    console.log('Initial NSFW status:', currentStatus);
                    
                    // Explicitly set data attribute to match rendered HTML
                    button.data('status', currentStatus);
                    
                    // Set menu visibility based on NSFW status - use native DOM for consistency
                    const nsfw_menu = document.getElementById('nsfw-menu-item');
                    if (nsfw_menu) {
                        console.log('Found NSFW menu element on init:', nsfw_menu);
                        
                        if (currentStatus === 'disabled') {
                            nsfw_menu.style.display = 'none';
                            console.log('Setting NSFW menu to hidden on init');
                        } else {
                            nsfw_menu.style.display = 'list-item';
                            console.log('Setting NSFW menu to visible on init');
                        }
                    } else {
                        console.error('NSFW menu element not found on init!');
                    }
                }
            });
            
            // Set CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // Toggle NSFW function with complete rewrite
            function toggleNsfw() {
                // Get elements using vanilla JavaScript for consistency
                const button = document.getElementById('nsfw-toggle-btn');
                const icon = document.getElementById('nsfw-toggle-icon');
                const nsfw_menu = document.getElementById('nsfw-menu-item');
                
                if (!button || !icon || !nsfw_menu) {
                    console.error('Required elements not found:', {button, icon, nsfw_menu});
                    return;
                }
                
                // Get current status from the button attribute
                const currentStatus = button.getAttribute('data-status');
                const newStatus = currentStatus === 'enabled' ? 'disabled' : 'enabled';
                const onDashboard = window.location.pathname === '/dashboard';
                
                console.log('Toggle clicked - Current status:', currentStatus);
                console.log('New status:', newStatus);
                console.log('NSFW menu element:', nsfw_menu);
                
                // Update the button and icon immediately for better UX
                if (newStatus === 'enabled') {
                    button.classList.remove('nsfw-disabled');
                    button.classList.add('nsfw-enabled');
                    icon.classList.remove('ri-shield-flash-line');
                    icon.classList.add('ri-shield-check-fill');
                    
                    // Show NSFW menu - try different approaches
                    nsfw_menu.style.removeProperty('display');
                    nsfw_menu.style.display = 'list-item';
                    
                    // Force repaint
                    void nsfw_menu.offsetWidth;
                    console.log('Menu should be visible now:', nsfw_menu.style.display);
                } else {
                    button.classList.remove('nsfw-enabled');
                    button.classList.add('nsfw-disabled');
                    icon.classList.remove('ri-shield-check-fill');
                    icon.classList.add('ri-shield-flash-line');
                    
                    // Hide NSFW menu
                    nsfw_menu.style.display = 'none';
                    
                    // Force repaint
                    void nsfw_menu.offsetWidth;
                    console.log('Menu should be hidden now:', nsfw_menu.style.display);
                }
                
                // Update the button's data attribute
                button.setAttribute('data-status', newStatus);
                
                // Send the AJAX request to update server-side state
                fetch('/settings/nsfw/ajax', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: 'status=' + encodeURIComponent(newStatus) + '&on_dashboard=' + encodeURIComponent(onDashboard)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('AJAX response:', data);
                    
                    if (data.success) {
                        // If we're on the dashboard and we have dashboard data, update it
                        if (onDashboard && data.totalPosts !== undefined) {
                            document.getElementById('total-posts').textContent = data.totalPosts.toLocaleString();
                            document.getElementById('total-views').textContent = data.totalViews.toLocaleString();
                            
                            // Update the posts lists
                            updatePostsList('#most-viewed-list', data.mostViewed);
                            updatePostsList('#recent-posts-list', data.recentPosts);
                        }
                    } else {
                        console.error('Server returned error:', data.message);
                        revertToggleState(currentStatus, button, icon, nsfw_menu);
                    }
                })
                .catch(error => {
                    console.error('AJAX Error:', error);
                    revertToggleState(currentStatus, button, icon, nsfw_menu);
                });
            }
            
            // Helper function to revert toggle state if the AJAX request fails
            function revertToggleState(originalStatus, button, icon, nsfw_menu) {
                if (originalStatus === 'enabled') {
                    button.classList.remove('nsfw-disabled');
                    button.classList.add('nsfw-enabled');
                    icon.classList.remove('ri-shield-flash-line');
                    icon.classList.add('ri-shield-check-fill');
                    nsfw_menu.style.display = 'list-item';
                } else {
                    button.classList.remove('nsfw-enabled');
                    button.classList.add('nsfw-disabled');
                    icon.classList.remove('ri-shield-check-fill');
                    icon.classList.add('ri-shield-flash-line');
                    nsfw_menu.style.display = 'none';
                }
                button.setAttribute('data-status', originalStatus);
            }
            
            // Function to refresh dashboard content
            function refreshDashboardContent(nsfwEnabled) {
                console.log('Refreshing dashboard content, NSFW enabled:', nsfwEnabled);
                
                $.ajax({
                    url: '/dashboard/ajax',
                    type: 'GET',
                    data: {
                        nsfw_enabled: nsfwEnabled
                    },
                    success: function(response) {
                        console.log('Dashboard AJAX response:', response);
                        
                        if (response.success) {
                            // Update dashboard statistics
                            $('#total-posts').text(response.totalPosts.toLocaleString());
                            $('#total-views').text(response.totalViews.toLocaleString());
                            
                            // Update most viewed posts
                            updatePostsList('#most-viewed-list', response.mostViewed);
                            
                            // Update recent posts
                            updatePostsList('#recent-posts-list', response.recentPosts);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Dashboard AJAX Error:', error);
                    }
                });
            }
            
            // Helper function to update posts lists
            function updatePostsList(listSelector, posts) {
                console.log('Updating posts list:', listSelector, posts);
                
                const list = $(listSelector);
                list.empty();
                
                if (posts.length === 0) {
                    list.append('<li class="dash-post-item">No posts available</li>');
                } else {
                    posts.forEach(post => {
                        let url = '#';
                        let iconClass = '';
                        
                        switch(post.type) {
                            case 'i': 
                                url = '/images/view/' + post.slug;
                                iconClass = 'ri-image-line';
                                break;
                            case 'n': 
                                url = '/nxleak/view/' + post.slug;
                                iconClass = 'ri-file-list-line';
                                break;
                            case 'w': 
                                url = '/wallpapers/view/' + post.slug;
                                iconClass = 'ri-image-2-line';
                                break;
                            case 'v': 
                                url = '/videos/view/' + post.slug;
                                iconClass = 'ri-video-line';
                                break;
                        }
                        
                        const itemHtml = `
                            <li class="dash-post-item">
                                <a href="${url}" class="dash-post-link">
                                    <span class="dash-post-title">${post.title}</span>
                                    <span class="dash-post-meta">
                                        <i class="${post.views ? 'ri-eye-line' : 'ri-calendar-line'}"></i>
                                        ${post.views ? post.views.toLocaleString() : new Date(post.created_at).toLocaleDateString()}
                                    </span>
                                </a>
                            </li>
                        `;
                        
                        list.append(itemHtml);
                    });
                }
            }
        </script>
        @yield('updatescript')
    </body>
</html>