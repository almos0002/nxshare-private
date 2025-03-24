@extends('layouts.auth')
@section('title', 'Login')
@section('header', 'Sign in to your account')
@section('subheader', 'Enter your credentials to access your account')
@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        
        <div>
            <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                Email address
            </label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ri-mail-line text-surface-400 dark:text-surface-500"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                       class="block w-full pl-10 py-2 border-surface-200 dark:border-surface-700 dark:bg-surface-800 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 dark:focus:ring-brand-500 dark:focus:border-brand-500 @error('email') border-brand-500 dark:border-brand-500 text-brand-900 dark:text-brand-400 placeholder-brand-300 dark:placeholder-brand-600 @enderror"
                       placeholder="you@example.com">
                @error('email')
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="ri-error-warning-line text-brand-500 dark:text-brand-400"></i>
                    </div>
                @enderror
            </div>
            @error('email')
                <p class="mt-2 text-sm text-brand-600 dark:text-brand-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                Password
            </label>
            <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ri-lock-line text-surface-400 dark:text-surface-500"></i>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="block w-full pl-10 py-2 border-surface-200 dark:border-surface-700 dark:bg-surface-800 rounded-md focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 dark:focus:ring-brand-500 dark:focus:border-brand-500 @error('password') border-brand-500 dark:border-brand-500 text-brand-900 dark:text-brand-400 placeholder-brand-300 dark:placeholder-brand-600 @enderror"
                       placeholder="••••••••">
                @error('password')
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="ri-error-warning-line text-brand-500 dark:text-brand-400"></i>
                    </div>
                @enderror
            </div>
            @error('password')
                <p class="mt-2 text-sm text-brand-600 dark:text-brand-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}
                       class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-surface-300 dark:border-surface-600 dark:bg-surface-700 rounded">
                <label for="remember" class="ml-2 block text-sm text-surface-700 dark:text-surface-300">
                    Remember me
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400 dark:hover:text-brand-300">
                        Forgot your password?
                    </a>
                </div>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 dark:focus:ring-offset-surface-800">
                Sign in
            </button>
        </div>
    </form>
@endsection

@section('footer_links')
    <div class="text-surface-600 dark:text-surface-400">
        Don't have an account?
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400 dark:hover:text-brand-300">
                Sign up
            </a>
        @else
            <span class="text-surface-400 dark:text-surface-600">Registration is currently disabled</span>
        @endif
    </div>
@endsection
