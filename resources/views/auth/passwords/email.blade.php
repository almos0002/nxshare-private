@extends('layouts.auth')
@section('title', 'Reset Password')
@section('header', 'Reset your password')
@section('subheader', 'Enter your email to receive a password reset link')
@section('content')
    @if (session('status'))
        <div class="mb-4 rounded-md bg-brand-50 dark:bg-brand-900/30 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="ri-checkbox-circle-line text-brand-400 dark:text-brand-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-brand-800 dark:text-brand-300">
                        {{ session('status') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 dark:focus:ring-offset-surface-800">
                Send Password Reset Link
            </button>
        </div>
    </form>
@endsection

@section('footer_links')
    <div class="text-surface-600 dark:text-surface-400">
        Remember your password?
        <a href="{{ route('login') }}" class="font-medium text-brand-600 hover:text-brand-500 dark:text-brand-400 dark:hover:text-brand-300">
            Sign in
        </a>
    </div>
@endsection
