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
        <title>@yield('title', 'Private Blog') - NxShare</title>
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
                    <li class="sidebar-menu-item" data-sidebar-menu-item>
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
        @yield('updatescript')
    </body>
</html>