<!DOCTYPE html>
<html lang="en" class="dark h-full">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#030712" media="(prefers-color-scheme: dark)">
        <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
        <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">
        
        <!-- Prevent dark mode flash -->
        <style>
            :root {
                color-scheme: light dark;
            }
            html.dark {
                background-color: rgb(3, 7, 18);
                color-scheme: dark;
            }
        </style>
        <script>
            // Immediately set dark mode before any content loads
            (function() {
                if (localStorage.getItem('darkMode') === null) {
                    localStorage.setItem('darkMode', 'true');
                }
                if (localStorage.getItem('darkMode') === 'true') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
        
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
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
        
        <title>@yield('title', 'Private Blog') - NxShare</title>
        <style>
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
        </style>
        <script>
            // Only set default if darkMode has never been set
            if (localStorage.getItem('darkMode') === null) {
                localStorage.setItem('darkMode', 'true');
            }
            // Apply the stored preference
            document.documentElement.classList.toggle('dark', localStorage.getItem('darkMode') === 'true');
        </script>
    </head>
    <body class="h-full bg-surface-50 dark:bg-surface-950 text-surface-900 dark:text-surface-100 antialiased">
        <div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <div class="flex justify-center">
                    <a href="{{ route('dashboard') }}" class="text-3xl font-bold text-brand-600 dark:text-brand-500">
                        NxShare
                    </a>
                </div>
                <h2 class="mt-6 text-center text-2xl font-bold tracking-tight text-surface-900 dark:text-white">
                    @yield('header', 'Welcome back')
                </h2>
                <p class="mt-2 text-center text-sm text-surface-600 dark:text-surface-400">
                    @yield('subheader', '')
                </p>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
                <div class="bg-white dark:bg-surface-900 py-8 px-4 shadow-sm sm:rounded-xl sm:px-10">
                    @yield('content')
                </div>
                
                @if(View::hasSection('footer_links'))
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-surface-200 dark:border-surface-800"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-surface-50 dark:bg-surface-950 px-2 text-surface-500 dark:text-surface-400">
                                Or
                            </span>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-center text-sm">
                        @yield('footer_links')
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    </body>
</html>
