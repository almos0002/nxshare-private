<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#030712" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">

    <!-- Prevent dark mode flash -->
    <style>
        /* Smooth theme transition */
        html {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        html.dark {
            color-scheme: dark;
            background-color: rgb(3, 7, 18);
        }
        
        /* Apply transitions to all elements that change with theme */
        body, div, header, footer, aside, nav, main, section, 
        .bg-white, .bg-surface-50, .bg-surface-100, .bg-surface-200, 
        .bg-surface-800, .bg-surface-900, .bg-surface-950,
        .dark\:bg-surface-700, .dark\:bg-surface-800, .dark\:bg-surface-900, .dark\:bg-surface-950,
        .text-surface-500, .text-surface-700, .text-surface-900,
        .dark\:text-surface-100, .dark\:text-surface-300, .dark\:text-surface-400, .dark\:text-white,
        .border-surface-200, .dark\:border-surface-800 {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        
        /* Specific sidebar styles to prevent flash */
        .sidebar {
            will-change: background-color;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        
        html.dark .sidebar {
            background-color: rgb(24, 24, 27) !important; /* surface-900 */
        }
        
        html:not(.dark) .sidebar {
            background-color: white !important;
        }
        
        /* Header styles to prevent flash */
        .app-header {
            will-change: background-color;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }
        
        html.dark .app-header {
            background-color: rgb(24, 24, 27) !important; /* surface-900 */
        }
        
        html:not(.dark) .app-header {
            background-color: white !important;
        }
        
        /* This ensures no white flash during page load */
        html.transition,
        html.transition *,
        html.transition *:before,
        html.transition *:after {
            transition: none !important;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.8);
        }

        /* Smooth transitions */
        .page-transition {
            transition: all 0.3s ease;
        }
        
        [x-cloak] {
            display: none !important;
        }
    </style>
    
    <!-- Theme initialization script - runs before page load -->
    <script>
        // Prevent flash by adding dark class before page renders
        (function() {
            // Add transition blocker class
            document.documentElement.classList.add('transition');
            
            // Check localStorage or use system preference
            const darkModeStored = localStorage.getItem('darkMode');
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Set initial theme
            if (darkModeStored === null) {
                // If no preference saved, use system preference
                localStorage.setItem('darkMode', systemPrefersDark ? 'true' : 'false');
                if (systemPrefersDark) {
                    document.documentElement.classList.add('dark');
                }
            } else if (darkModeStored === 'true') {
                document.documentElement.classList.add('dark');
            }
            
            // Remove transition blocker after a short delay
            window.addEventListener('load', () => {
                setTimeout(() => {
                    document.documentElement.classList.remove('transition');
                }, 10);
            });
        })();
    </script>

    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e',
                        },
                        surface: {
                            50: '#fafafa',
                            100: '#f4f4f5',
                            200: '#e4e4e7',
                            300: '#d4d4d8',
                            400: '#a1a1aa',
                            500: '#71717a',
                            600: '#52525b',
                            700: '#3f3f46',
                            800: '#27272a',
                            900: '#18181b',
                            950: '#09090b',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter var', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <!-- Inter font -->
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <title>@yield('title', 'Private Blog') - NxShare</title>
</head>

<body class="bg-surface-50 text-surface-900 dark:bg-surface-950 dark:text-surface-100 antialiased"
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        mobileMenuOpen: false,
        mobileSearchOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
        tooltipText: '',
        tooltipX: 0,
        tooltipY: 0,
        tooltipVisible: false,
        toggleDarkMode() {
            // Add transition blocker to prevent flash
            document.documentElement.classList.add('transition');
            
            // Toggle dark mode with a slight delay to ensure transition blocker takes effect
            setTimeout(() => {
                this.darkMode = !this.darkMode;
                localStorage.setItem('darkMode', this.darkMode);
                document.documentElement.classList.toggle('dark', this.darkMode);
                
                // Remove transition blocker after the change is applied
                setTimeout(() => {
                    document.documentElement.classList.remove('transition');
                }, 20);
            }, 5);
        }
    }" x-init="document.documentElement.classList.toggle('dark', darkMode);
    $watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val));
    $el.addEventListener('tooltip-enter', e => {
        tooltipText = e.detail.text;
        const rect = e.detail.el.getBoundingClientRect();
        tooltipX = rect.right + 10;
        tooltipY = rect.top + rect.height / 2;
        tooltipVisible = true;
    });
    $el.addEventListener('tooltip-leave', () => {
        tooltipVisible = false;
    });" x-cloak>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tooltip', () => ({
                show: false,
                text: '',
                enter(text) {
                    this.text = text;
                    this.show = true;
                },
                leave() {
                    this.show = false;
                }
            }));
        });
    </script>

    <div class="flex h-screen overflow-hidden">
        <!-- Mobile menu backdrop -->
        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
            class="fixed inset-0 z-20 bg-surface-900/80 backdrop-blur-sm lg:hidden"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Sidebar -->
        <div x-show="mobileMenuOpen || window.innerWidth >= 1024" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" :class="sidebarCollapsed ? 'w-20' : 'w-72'"
            class="fixed inset-y-0 left-0 z-30 flex flex-col bg-white dark:bg-surface-900 shadow-xl lg:shadow-none lg:relative lg:translate-x-0 transition-all duration-300 sidebar">
            <!-- Logo section with exact height to match header -->
            <div class="h-16 border-b border-surface-200 dark:border-surface-800">
                <div class="flex h-16 items-center justify-between px-4">
                    <a href="#" class="flex items-center space-x-3"
                        :class="{ 'justify-center': sidebarCollapsed, 'w-full': sidebarCollapsed }">
                        <img src="https://i.postimg.cc/4dbDJLpG/favicon.png" alt="NxShare" class="h-8 w-8">
                        <span
                            class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-brand-600 to-brand-400"
                            x-show="!sidebarCollapsed">NxShare</span>
                    </a>
                </div>
            </div>

            <!-- User profile -->
            <div class="px-4 py-4 border-b border-surface-200 dark:border-surface-800"
                :class="{ 'px-2': sidebarCollapsed }">
                <div class="flex items-center space-x-3" :class="{ 'justify-center': sidebarCollapsed }">
                    <img src="https://i.postimg.cc/JhnVsqv9/fire.png" alt="Profile"
                        class="h-10 w-10 rounded-full ring-2 ring-brand-500 dark:ring-brand-400">
                    <div x-show="!sidebarCollapsed">
                        <p class="font-medium text-surface-900 dark:text-white">{{ Auth::user()->name ?? 'User' }}</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">
                            {{ Auth::user()->email ?? 'user@example.com' }}</p>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-2" x-show="!sidebarCollapsed">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700 transition-colors">
                        <i class="ri-user-settings-line mr-2 text-brand-500 dark:text-brand-400"></i> Profile
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30">
                        <i class="ri-logout-box-line mr-2 text-red-500 dark:text-red-400"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto py-4 px-3" :class="{ 'px-2': sidebarCollapsed }">
                <div class="space-y-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-surface-500 dark:text-surface-400 mb-2"
                        x-show="!sidebarCollapsed">
                        Main
                    </p>

                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'text-surface-900 dark:text-white bg-surface-100 dark:bg-surface-800' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                        :class="{ 'justify-center': sidebarCollapsed }"
                        @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Dashboard', el: $el})"
                        @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                        <i class="ri-dashboard-line text-lg text-surface-500 dark:text-surface-400"
                            :class="sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
                        <span x-show="!sidebarCollapsed">Dashboard</span>
                    </a>

                    <div x-data="{ open: {{ request()->routeIs('addwp') || request()->routeIs('addpfp') ? 'true' : 'false' }} }" class="space-y-1">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('addwp') || request()->routeIs('addpfp') ? 'text-surface-900 dark:text-white bg-surface-100 dark:bg-surface-800' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                            :class="{ 'justify-center': sidebarCollapsed }"
                            @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'SFW Content', el: $el})"
                            @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                            <div class="flex items-center" :class="{ 'justify-center w-full': sidebarCollapsed }">
                                <i class="ri-bubble-chart-line text-lg text-brand-500 dark:text-brand-400"
                                    :class="sidebarCollapsed ? 'mx-auto text-xl' : 'mr-3'"></i>
                                <span x-show="!sidebarCollapsed">SFW Content</span>
                            </div>
                            <i :class="open ? 'ri-arrow-down-s-line' : 'ri-arrow-right-s-line'" class="text-lg"
                                x-show="!sidebarCollapsed"></i>
                        </button>
                        <div x-show="open" class="space-y-1"
                            :class="{ 'pl-0 mt-1': sidebarCollapsed, 'pl-10': !sidebarCollapsed }">
                            <a href="{{ route('addwp') }}"
                                class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('addwp') ? 'bg-surface-100 dark:bg-surface-800 text-brand-600 dark:text-brand-400 font-medium' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                                :class="{ 'text-center': sidebarCollapsed }"
                                @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Wallpapers', el: $el})"
                                @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="ri-corner-down-right-line {{ request()->routeIs('addwp') ? 'text-brand-500' : 'text-surface-500' }}"
                                        :class="sidebarCollapsed ? 'mx-auto text-sm' : 'mr-2'"></i>
                                    <span x-show="!sidebarCollapsed">Wallpapers</span>
                                </div>
                            </a>
                            <a href="{{ route('addpfp') }}"
                                class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('addpfp') ? 'bg-surface-100 dark:bg-surface-800 text-brand-600 dark:text-brand-400 font-medium' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                                :class="{ 'text-center': sidebarCollapsed }"
                                @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Profile Pictures', el: $el})"
                                @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="ri-corner-down-right-line {{ request()->routeIs('addpfp') ? 'text-brand-500' : 'text-surface-500' }}"
                                        :class="sidebarCollapsed ? 'mx-auto text-sm' : 'mr-2'"></i>
                                    <span x-show="!sidebarCollapsed">Profile Pictures</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div x-data="{ open: {{ request()->routeIs('addnx') || request()->routeIs('addimg') || request()->routeIs('addvd') ? 'true' : 'false' }} }" class="space-y-1" id="nsfw-menu-item"
                        style="display: {{ Auth::check() && Auth::user()->settings && Auth::user()->settings->nsfw === 'enabled' ? 'block' : 'none' }};">
                        <button @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('addnx') || request()->routeIs('addimg') || request()->routeIs('addvd') ? 'text-surface-900 dark:text-white bg-surface-100 dark:bg-surface-800' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                            :class="{ 'justify-center': sidebarCollapsed }"
                            @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'NSFW Content', el: $el})"
                            @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                            <div class="flex items-center" :class="{ 'justify-center w-full': sidebarCollapsed }">
                                <i class="ri-vip-crown-line text-lg text-red-500 dark:text-red-400"
                                    :class="sidebarCollapsed ? 'mx-auto text-xl' : 'mr-3'"></i>
                                <span x-show="!sidebarCollapsed">NSFW Content</span>
                            </div>
                            <i :class="open ? 'ri-arrow-down-s-line' : 'ri-arrow-right-s-line'" class="text-lg"
                                x-show="!sidebarCollapsed"></i>
                        </button>
                        <div x-show="open" class="space-y-1"
                            :class="{ 'pl-0 mt-1': sidebarCollapsed, 'pl-10': !sidebarCollapsed }">
                            <a href="{{ route('addnx') }}"
                                class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('addnx') ? 'bg-surface-100 dark:bg-surface-800 text-red-600 dark:text-red-400 font-medium' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                                :class="{ 'text-center': sidebarCollapsed }"
                                @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Nxleak', el: $el})"
                                @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="ri-corner-down-right-line {{ request()->routeIs('addnx') ? 'text-red-500' : 'text-surface-500' }}"
                                        :class="sidebarCollapsed ? 'mx-auto text-sm' : 'mr-2'"></i>
                                    <span x-show="!sidebarCollapsed">Nxleak</span>
                                </div>
                            </a>
                            <a href="{{ route('addimg') }}"
                                class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('addimg') ? 'bg-surface-100 dark:bg-surface-800 text-red-600 dark:text-red-400 font-medium' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                                :class="{ 'text-center': sidebarCollapsed }"
                                @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Images', el: $el})"
                                @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="ri-corner-down-right-line {{ request()->routeIs('addimg') ? 'text-red-500' : 'text-surface-500' }}"
                                        :class="sidebarCollapsed ? 'mx-auto text-sm' : 'mr-2'"></i>
                                    <span x-show="!sidebarCollapsed">Images</span>
                                </div>
                            </a>
                            <a href="{{ route('addvd') }}"
                                class="block px-3 py-2 text-sm rounded-lg {{ request()->routeIs('addvd') ? 'bg-surface-100 dark:bg-surface-800 text-red-600 dark:text-red-400 font-medium' : 'text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                                :class="{ 'text-center': sidebarCollapsed }"
                                @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Videos', el: $el})"
                                @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                                <div class="flex items-center" :class="{ 'justify-center': sidebarCollapsed }">
                                    <i class="ri-corner-down-right-line {{ request()->routeIs('addvd') ? 'text-red-500' : 'text-surface-500' }}"
                                        :class="sidebarCollapsed ? 'mx-auto text-sm' : 'mr-2'"></i>
                                    <span x-show="!sidebarCollapsed">Videos</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-8 space-y-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-surface-500 dark:text-surface-400 mb-2"
                        x-show="!sidebarCollapsed">
                        Other
                    </p>

                    <a href="{{ route('settings.edit') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('settings.edit') ? 'text-surface-900 dark:text-white bg-surface-100 dark:bg-surface-800' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                        :class="{ 'justify-center': sidebarCollapsed }"
                        @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Settings', el: $el})"
                        @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                        <i class="ri-settings-3-line text-lg text-surface-500 dark:text-surface-400"
                            :class="sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
                        <span x-show="!sidebarCollapsed">Settings</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('profile.edit') ? 'text-surface-900 dark:text-white bg-surface-100 dark:bg-surface-800' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800' }}"
                        :class="{ 'justify-center': sidebarCollapsed }"
                        @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: 'Profile', el: $el})"
                        @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                        <i class="ri-user-settings-line text-lg text-surface-500 dark:text-surface-400"
                            :class="sidebarCollapsed ? 'mx-auto' : 'mr-3'"></i>
                        <span x-show="!sidebarCollapsed">Profile</span>
                    </a>
                </div>
            </div>

            <!-- Theme toggle -->
            <div class="p-4 border-t border-surface-200 dark:border-surface-800"
                :class="{ 'px-2': sidebarCollapsed }">
                <button @click="toggleDarkMode()"
                    class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800"
                    :class="{ 'justify-center': sidebarCollapsed }"
                    @mouseenter="sidebarCollapsed && $dispatch('tooltip-enter', {text: darkMode ? 'Light Mode' : 'Dark Mode', el: $el})"
                    @mouseleave="sidebarCollapsed && $dispatch('tooltip-leave')">
                    <template x-if="!sidebarCollapsed">
                        <div class="flex items-center justify-between w-full">
                            <span>Theme</span>
                            <div class="relative inline-flex h-6 w-11 items-center rounded-full transition-all duration-150"
                                :class="darkMode ? 'bg-brand-600 dark:bg-brand-500' : 'bg-surface-300 dark:bg-surface-600'">
                                <div class="inline-flex h-4 w-4 transform items-center justify-center rounded-full bg-white transition-all duration-150"
                                    :class="darkMode ? 'translate-x-6' : 'translate-x-1'">
                                    <i class="text-xs"
                                        :class="darkMode ? 'ri-moon-line text-brand-600' : 'ri-sun-line text-yellow-400'"></i>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template x-if="sidebarCollapsed">
                        <i class="text-lg" :class="darkMode ? 'ri-moon-line' : 'ri-sun-line'"></i>
                    </template>
                </button>
            </div>
        </div>

        <!-- Mobile Search Overlay -->
        <div x-show="mobileSearchOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="fixed inset-0 z-40 bg-surface-900/90 backdrop-blur-sm flex items-start justify-center pt-20 px-4 lg:hidden">
            <div class="w-full max-w-md bg-white dark:bg-surface-800 rounded-lg shadow-xl overflow-hidden">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="ri-search-line text-surface-400 dark:text-surface-500"></i>
                    </span>
                    <input type="text" placeholder="Search..."
                        class="w-full py-3 pl-10 pr-10 bg-white dark:bg-surface-800 border-0 focus:ring-0">
                    <button @click="mobileSearchOpen = false"
                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i class="ri-close-line text-surface-400 dark:text-surface-500 text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top header -->
            <header class="app-header h-16 bg-white dark:bg-surface-900 border-b border-surface-200 dark:border-surface-800 shadow-sm">
                <div class="flex items-center justify-between h-16 px-4 md:px-6">
                    <div class="flex items-center">
                        <button @click="mobileMenuOpen = true"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700 transition-colors lg:hidden">
                            <i class="ri-menu-line text-xl"></i>
                        </button>

                        <button @click="sidebarCollapsed = !sidebarCollapsed"
                            class="hidden lg:inline-flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700 transition-colors ml-2">
                            <i class="ri-menu-fold-line text-xl" x-show="!sidebarCollapsed"></i>
                            <i class="ri-menu-unfold-line text-xl" x-show="sidebarCollapsed"></i>
                        </button>

                        <div class="ml-4">
                            <h1 class="text-xl font-semibold text-surface-900 dark:text-white">@yield('title', 'Dashboard')</h1>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="hidden md:block relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <i class="ri-search-line text-surface-400 dark:text-surface-500"></i>
                            </span>
                            <input type="text" placeholder="Search..."
                                class="py-2 pl-10 pr-4 w-64 rounded-lg bg-surface-100 dark:bg-surface-800 border-transparent focus:border-brand-500 focus:ring focus:ring-brand-200 dark:focus:ring-brand-800 dark:focus:border-brand-500">
                        </div>

                        <!-- Mobile Search Button -->
                        <button @click="mobileSearchOpen = true"
                            class="md:hidden inline-flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700 transition-colors">
                            <i class="ri-search-line text-xl"></i>
                        </button>

                        <!-- NSFW Toggle Button -->
                        <button id="nsfw-toggle-btn"
                            class="relative inline-flex h-10 w-10 items-center justify-center rounded-lg transition-all duration-200"
                            :class="{ 'bg-green-600 hover:bg-green-700': {{ Auth::check() && Auth::user()->settings && Auth::user()->settings->nsfw === 'enabled' ? 'true' : 'false' }}, 'bg-red-600 hover:bg-red-700': {{ Auth::check() && Auth::user()->settings && Auth::user()->settings->nsfw === 'enabled' ? 'false' : 'true' }} }">
                            <i id="nsfw-toggle-icon"
                                class="{{ Auth::check() && Auth::user()->settings && Auth::user()->settings->nsfw === 'enabled' ? 'ri-shield-check-fill' : 'ri-shield-flash-line' }} text-white text-lg"></i>
                            <span class="sr-only">Toggle NSFW Content</span>
                        </button>

                        <!-- Notifications -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="relative inline-flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 dark:bg-surface-800 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-700 transition-colors">
                                <i class="ri-notification-3-line text-xl"></i>
                                <span
                                    class="absolute -top-1 -right-1 h-5 w-5 flex items-center justify-center rounded-full bg-red-500 text-white text-xs font-medium">4</span>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                class="absolute right-0 mt-2 w-80 origin-top-right rounded-lg bg-white dark:bg-surface-900 shadow-lg ring-1 ring-surface-200 dark:ring-surface-800 focus:outline-none z-50"
                                :class="{
                                    'right-0': window.innerWidth >= 640,
                                    'right-[-70px] sm:right-0': window.innerWidth <
                                        640
                                }">
                                <div class="px-4 py-3 border-b border-surface-200 dark:border-surface-800">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">
                                            Notifications</h3>
                                        <span
                                            class="text-xs font-medium px-2 py-0.5 rounded-full bg-brand-100 text-brand-800 dark:bg-brand-900 dark:text-brand-200">4
                                            New</span>
                                    </div>
                                </div>

                                <div class="max-h-96 overflow-y-auto">
                                    <a href="#"
                                        class="block px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-700/50">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-3">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-brand-100 dark:bg-brand-900 flex items-center justify-center">
                                                    <i class="ri-user-line text-brand-600 dark:text-brand-400"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-surface-900 dark:text-white">New
                                                    user registered</p>
                                                <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">3
                                                    minutes ago</p>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="#"
                                        class="block px-4 py-3 hover:bg-surface-50 dark:hover:bg-surface-700/50">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 mr-3">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                                    <i
                                                        class="ri-file-text-line text-green-600 dark:text-green-400"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-surface-900 dark:text-white">New
                                                    post created</p>
                                                <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">1 hour
                                                    ago</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="px-4 py-2 border-t border-surface-200 dark:border-surface-800">
                                    <a href="#"
                                        class="text-xs text-brand-600 dark:text-brand-400 hover:underline">View all
                                        notifications</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto bg-surface-50 dark:bg-surface-950 p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Tooltip -->
    <div x-show="tooltipVisible"
        :style="`position: fixed; left: ${tooltipX}px; top: ${tooltipY}px; transform: translateY(-50%); z-index: 100;`"
        class="bg-surface-800 text-white text-sm py-1 px-2 rounded shadow-lg transition-opacity duration-200"
        :class="tooltipVisible ? 'opacity-100' : 'opacity-0'" style="pointer-events: none;">
        <span x-text="tooltipText"></span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // NSFW Toggle Functionality
            const nsfwToggleBtn = document.getElementById('nsfw-toggle-btn');
            if (nsfwToggleBtn) {
                nsfwToggleBtn.addEventListener('click', toggleNsfw);
            }
        });

        function toggleNsfw() {
            // Get elements using vanilla JavaScript for consistency
            const button = document.getElementById('nsfw-toggle-btn');
            const icon = document.getElementById('nsfw-toggle-icon');
            const nsfw_menu = document.getElementById('nsfw-menu-item');

            // Get current status from button class
            const currentStatus = button.classList.contains('bg-green-600') ? 'enabled' : 'disabled';
            
            // Show loading indicator on the button
            const originalButtonContent = button.innerHTML;
            button.innerHTML = '<div class="w-5 h-5 border-t-2 border-r-2 border-white rounded-full animate-spin"></div>';
            
            // Toggle visual state immediately for better UX
            if (currentStatus === 'enabled') {
                button.classList.remove('bg-green-600');
                button.classList.add('bg-red-600');
                nsfw_menu.style.display = 'none';
            } else {
                button.classList.remove('bg-red-600');
                button.classList.add('bg-green-600');
                nsfw_menu.style.display = 'block';
            }

            // Determine if we're on the dashboard page
            const onDashboard = window.location.pathname === '/dashboard' || window.location.pathname === '/';
            
            // If on dashboard, preload empty UI state to improve perceived performance
            if (onDashboard) {
                // Pre-update the UI with loading state
                if (currentStatus === 'enabled') {
                    // Going from enabled to disabled, show fewer posts
                    document.querySelectorAll('.total-posts-value').forEach(function(el) {
                        el.innerHTML = '<span class="animate-pulse">...</span>';
                    });
                    document.querySelectorAll('.total-views-value').forEach(function(el) {
                        el.innerHTML = '<span class="animate-pulse">...</span>';
                    });
                }
            }

            // Send AJAX request to update server-side state
            $.ajax({
                url: '{{ route('settings.nsfw.ajax') }}',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: currentStatus === 'enabled' ? 'disabled' : 'enabled',
                    on_dashboard: onDashboard
                },
                success: function(response) {
                    // Restore the button content
                    button.innerHTML = originalButtonContent;
                    
                    // Update icon based on new status
                    if (currentStatus === 'enabled') {
                        icon.classList.remove('ri-shield-check-fill');
                        icon.classList.add('ri-shield-flash-line');
                    } else {
                        icon.classList.remove('ri-shield-flash-line');
                        icon.classList.add('ri-shield-check-fill');
                    }
                    
                    // If we're on the dashboard and the response includes dashboard data, update the UI
                    if (onDashboard) {
                        console.log('On dashboard, checking for dashboard data');
                        
                        if (response.dashboardData) {
                            console.log('Dashboard data found:', response.dashboardData);
                            
                            // Update total posts count
                            if (response.dashboardData.totalPosts !== undefined) {
                                document.querySelectorAll('.total-posts-value').forEach(function(el) {
                                    el.textContent = response.dashboardData.totalPosts;
                                });
                            }

                            // Update total views count
                            if (response.dashboardData.totalViews !== undefined) {
                                document.querySelectorAll('.total-views-value').forEach(function(el) {
                                    el.textContent = response.dashboardData.totalViews;
                                });
                            }

                            // Update most viewed posts section
                            if (response.dashboardData.mostViewed) {
                                updatePostsSection(response.dashboardData.mostViewed, 'Top Viewed Posts');
                            }

                            // Update recent posts section
                            if (response.dashboardData.recentPosts) {
                                updatePostsSection(response.dashboardData.recentPosts, 'Recent Posts');
                            }
                        } else {
                            console.error('No dashboard data in response');
                        }
                    } else {
                        console.log('Not on dashboard, skipping UI updates');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('NSFW toggle failed:', error);

                    // Revert the toggle state on error
                    if (currentStatus === 'enabled') {
                        button.classList.remove('bg-red-600');
                        button.classList.add('bg-green-600');
                        icon.classList.remove('ri-shield-flash-line');
                        icon.classList.add('ri-shield-check-fill');
                        nsfw_menu.style.display = 'block';
                    } else {
                        button.classList.remove('bg-green-600');
                        button.classList.add('bg-red-600');
                        icon.classList.remove('ri-shield-check-fill');
                        icon.classList.add('ri-shield-flash-line');
                        nsfw_menu.style.display = 'none';
                    }

                    // Show error message
                    alert('Failed to toggle NSFW setting. Please try again.');
                }
            });
        }

        // Function to update posts sections (Most Viewed and Recent Posts)
        function updatePostsSection(posts, sectionTitle) {
            console.log(`Updating ${sectionTitle} section with ${posts.length} posts`);
            
            // Determine which container to update based on section title
            let containerId = '';
            if (sectionTitle === 'Top Viewed Posts') {
                containerId = 'top-viewed-posts-container';
            } else if (sectionTitle === 'Recent Posts') {
                containerId = 'recent-posts-container';
            } else {
                console.error(`Unknown section title: ${sectionTitle}`);
                return;
            }
            
            // Get the container by ID
            const postsContainer = document.getElementById(containerId);
            if (!postsContainer) {
                console.error(`Container with ID "${containerId}" not found`);
                return;
            }
            
            // Clear existing posts
            postsContainer.innerHTML = '';
            
            // Add new posts
            posts.forEach(post => {
                // Determine the color based on post type
                const typeColor = post.type === 'w' ? 'blue' : 
                                 (post.type === 'p' ? 'purple' : 
                                 (post.type === 'n' ? 'red' : 
                                 (post.type === 'i' ? 'green' : 'amber')));
                
                // Format the date
                const date = new Date(post.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                
                // Create the post element
                const postElement = document.createElement('div');
                postElement.className = 'flex items-center p-4 transition-colors hover:bg-surface-50 dark:hover:bg-surface-700/50';
                postElement.innerHTML = `
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-100 font-bold text-${typeColor}-600 dark:bg-surface-700 dark:text-${typeColor}-400">
                            ${post.title.charAt(0)}
                        </div>
                    </div>
                    <div class="ml-4 flex-1 min-w-0">
                        <p class="truncate text-sm font-medium text-surface-900 dark:text-white">${post.title}</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">${formattedDate}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center text-surface-500 dark:text-surface-400">
                            <i class="ri-eye-line mr-1 text-sm"></i>
                            <span class="text-xs">${post.views}</span>
                        </div>
                        <a href="/${post.type == 'i' ? 'i' : (post.type == 'n' ? 'n' : (post.type == 'w' ? 'w' : (post.type == 'p' ? 'p' : 'v')))}/${post.slug}" class="flex h-8 w-8 items-center justify-center rounded-lg text-surface-500 transition-colors hover:bg-surface-100 hover:text-brand-600 dark:text-surface-400 dark:hover:bg-surface-700 dark:hover:text-brand-400">
                            <i class="ri-external-link-line text-lg"></i>
                        </a>
                    </div>
                `;
                
                postsContainer.appendChild(postElement);
            });
            
            console.log(`Updated ${sectionTitle} section successfully`);
        }
    </script>
    @yield('updatescript')
</body>

</html>
