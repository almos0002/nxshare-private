@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="space-y-8">
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-600 to-brand-800 text-white shadow-lg">
            <div class="absolute inset-0 bg-pattern opacity-10"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(255,255,255,0.5)\'/%3E%3C/svg%3E');">
            </div>
            <div class="relative px-6 py-8 md:px-8 md:py-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl font-bold">Your Profile</h1>
                        <p class="mt-1 text-brand-100">Update your personal information and password</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Stats -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <!-- Account Status -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Account Status</p>
                        <h3 class="mt-1 text-xl font-bold text-surface-900 dark:text-white">Active</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/50 dark:text-emerald-400">
                        <i class="ri-shield-check-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <span
                        class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                        Verified
                    </span>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-emerald-700 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>

            <!-- Member Since -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Member Since</p>
                        <h3 class="mt-1 text-xl font-bold text-surface-900 dark:text-white">
                            {{ $user->created_at->format('M d, Y') }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400">
                        <i class="ri-calendar-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="flex items-center text-surface-500 dark:text-surface-400">
                        <i class="ri-time-line mr-1"></i>
                        {{ $user->created_at->diffForHumans() }}
                    </span>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 to-blue-700 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>

            <!-- Last Login -->
            <div
                class="group relative overflow-hidden rounded-xl bg-white p-6 shadow-sm transition-all hover:shadow-md dark:bg-surface-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-surface-500 dark:text-surface-400">Last Login</p>
                        <h3 class="mt-1 text-xl font-bold text-surface-900 dark:text-white">
                            {{ $user->last_login ? $user->last_login->format('M d, Y') : 'N/A' }}</h3>
                    </div>
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/50 dark:text-purple-400">
                        <i class="ri-login-circle-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="flex items-center text-surface-500 dark:text-surface-400">
                        <i class="ri-time-line mr-1"></i>
                        {{ $user->last_login ? $user->last_login->diffForHumans() : 'Never logged in' }}
                    </span>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-purple-700 opacity-0 transition-opacity group-hover:opacity-100">
                </div>
            </div>
        </div>

        <form id="profile-form" method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf

            <!-- Personal Information Card -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
                <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Personal Information</h2>
                    <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Update your account's profile information
                    </p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Name -->
                        <div>
                            <label for="name"
                                class="block text-sm font-medium text-surface-700 dark:text-surface-300">Full Name</label>
                            <div class="mt-1">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="ri-user-line text-surface-400"></i>
                                    </div>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $user->name) }}" placeholder="Enter your full name"
                                        class="block w-full rounded-md border-surface-300 pl-10 py-2.5 text-surface-900 placeholder:text-surface-400 focus:border-brand-500 focus:ring-brand-500 dark:border-surface-600 dark:bg-surface-700 dark:text-white dark:placeholder:text-surface-500">
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-surface-700 dark:text-surface-300">Email
                                Address</label>
                            <div class="mt-1">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="ri-mail-line text-surface-400"></i>
                                    </div>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user->email) }}" placeholder="Enter your email address"
                                        class="block w-full rounded-md border-surface-300 pl-10 py-2.5 text-surface-900 placeholder:text-surface-400 focus:border-brand-500 focus:ring-brand-500 dark:border-surface-600 dark:bg-surface-700 dark:text-white dark:placeholder:text-surface-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Redirect Toggle -->
                    <div class="flex items-center justify-between mt-4">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-surface-700 dark:text-surface-300">Enable Profile
                                Notifications</h3>
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">Receive notifications when
                                someone views your profile</p>
                        </div>
                        <div class="flex items-center">
                            <label for="notifications_enabled" class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" id="notifications_enabled" name="notifications_enabled"
                                    value="1" class="peer sr-only"
                                    {{ isset($settings->notifications_enabled) && $settings->notifications_enabled ? 'checked' : '' }}>
                                <div
                                    class="peer h-6 w-11 rounded-full bg-surface-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-brand-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-300 dark:border-gray-600 dark:bg-surface-700 dark:peer-focus:ring-brand-800">
                                </div>
                                <span class="ml-3 text-sm font-medium text-surface-700 dark:text-surface-300"
                                    id="notifications_status">{{ isset($settings->notifications_enabled) && $settings->notifications_enabled ? 'Enabled' : 'Disabled' }}</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Card -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
                <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Update Password</h2>
                    <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Ensure your account is using a secure
                        password</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-surface-700 dark:text-surface-300">New
                                Password</label>
                            <div class="mt-1">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="ri-lock-line text-surface-400"></i>
                                    </div>
                                    <input type="password" name="password" id="password"
                                        placeholder="Enter new password"
                                        class="block w-full rounded-md border-surface-300 pl-10 py-2.5 text-surface-900 placeholder:text-surface-400 focus:border-brand-500 focus:ring-brand-500 dark:border-surface-600 dark:bg-surface-700 dark:text-white dark:placeholder:text-surface-500">
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation"
                                class="block text-sm font-medium text-surface-700 dark:text-surface-300">Confirm
                                Password</label>
                            <div class="mt-1">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="ri-lock-line text-surface-400"></i>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        placeholder="Confirm your new password"
                                        class="block w-full rounded-md border-surface-300 pl-10 py-2.5 text-surface-900 placeholder:text-surface-400 focus:border-brand-500 focus:ring-brand-500 dark:border-surface-600 dark:bg-surface-700 dark:text-white dark:placeholder:text-surface-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="text-xs text-surface-500 dark:text-surface-400 bg-surface-50 dark:bg-surface-700/50 p-3 rounded-md">
                        <div class="flex items-center">
                            <i class="ri-information-line mr-2 text-indigo-500"></i>
                            <span>Password should be at least 8 characters and include a mix of letters, numbers, and
                                symbols for better security.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="reset"
                    class="inline-flex items-center justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-medium text-surface-700 shadow-sm hover:bg-surface-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:border-surface-600 dark:bg-surface-800 dark:text-surface-300 dark:hover:bg-surface-700">
                    <i class="ri-refresh-line mr-1.5"></i> Reset
                </button>
                <button type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:bg-brand-500 dark:hover:bg-brand-600 dark:focus:ring-brand-400">
                    <i class="ri-save-line mr-1.5"></i> Save Profile
                </button>
            </div>

            <!-- Mobile Save Button -->
            <div class="md:hidden">
                <button type="submit"
                    class="w-full rounded-lg bg-brand-600 px-4 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 dark:bg-brand-500 dark:hover:bg-brand-600 dark:focus:ring-brand-400">
                    <i class="ri-save-line mr-1.5"></i> Save Profile
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationsToggle = document.getElementById('notifications_enabled');
            const notificationsStatus = document.getElementById('notifications_status');

            if (notificationsToggle && notificationsStatus) {
                notificationsToggle.addEventListener('change', function() {
                    notificationsStatus.textContent = this.checked ? 'Enabled' : 'Disabled';
                });
            }
        });
    </script>
@endsection
