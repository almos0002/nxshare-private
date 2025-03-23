@extends('layouts.app')
@section('title', 'Settings')
@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-500 text-white shadow-lg">
        <div class="absolute inset-0 bg-pattern opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'30\' height=\'30\' viewBox=\'0 0 30 30\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\' fill=\'rgba(255,255,255,0.5)\'/%3E%3C/svg%3E');"></div>
        <div class="relative px-6 py-8 md:px-8 md:py-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold">Application Settings</h1>
                    <p class="mt-1 text-indigo-100">Manage your application preferences and configurations</p>
                </div>
            </div>
        </div>
    </div>

    <form id="settings-form" method="POST" action="{{ route('settings.update') }}" class="space-y-6">
        @csrf

        <!-- Domain Settings Card -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
            <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Domain Settings</h2>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Configure your active domain and redirect preferences</p>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Active Domain -->
                    <div>
                        <label for="active_domain" class="block text-sm font-medium text-surface-700 dark:text-surface-300">Active Domain</label>
                        <div class="mt-1">
                            <div class="relative rounded-md shadow-sm">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <i class="ri-global-line text-surface-400"></i>
                                </div>
                                <input type="url" name="active_domain" id="active_domain" value="{{ old('active_domain', $settings->active_domain) }}" placeholder="https://example.com" class="block w-full rounded-md border-surface-300 pl-10 py-2.5 text-surface-900 placeholder:text-surface-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-surface-600 dark:bg-surface-700 dark:text-white dark:placeholder:text-surface-500">
                            </div>
                            <p class="mt-1.5 text-xs text-surface-500 dark:text-surface-400">Enter the full URL including http:// or https://</p>
                        </div>
                    </div>

                    <!-- Enable Redirects -->
                    <div>
                        <label for="redirect_enabled" class="block text-sm font-medium text-surface-700 dark:text-surface-300">Enable Redirects</label>
                        <div class="mt-1">
                            <div class="flex items-center">
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input type="hidden" name="redirect_enabled" value="0">
                                    <input type="checkbox" name="redirect_enabled" id="redirect_enabled" value="1" class="peer sr-only" {{ old('redirect_enabled', $settings->redirect_enabled) ? 'checked' : '' }}>
                                    <div class="h-6 w-11 rounded-full bg-surface-200 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-indigo-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:border-gray-600 dark:bg-surface-700 dark:peer-focus:ring-indigo-800"></div>
                                    <span class="ml-3 text-sm font-medium text-surface-700 dark:text-surface-300" id="redirect_status">{{ old('redirect_enabled', $settings->redirect_enabled) ? 'Enabled' : 'Disabled' }}</span>
                                </label>
                            </div>
                            <p class="mt-1.5 text-xs text-surface-500 dark:text-surface-400">When enabled, users will be redirected to the active domain</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advertisement Settings Card -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm dark:bg-surface-800">
            <div class="border-b border-surface-200 px-6 py-4 dark:border-surface-700">
                <h2 class="text-lg font-semibold text-surface-900 dark:text-white">Advertisement Settings</h2>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Configure advertisement code for different sections</p>
            </div>
            <div class="p-6 space-y-6">
                <!-- Ad Section 1 -->
                <div>
                    <label for="ad1" class="block text-sm font-medium text-surface-700 dark:text-surface-300">Ad Section 1</label>
                    <div class="mt-1">
                        <textarea name="ad1" id="ad1" rows="4" placeholder="Enter HTML or JavaScript code for ad section 1" class="block w-full rounded-md border-surface-300 py-2 text-surface-900 placeholder:text-surface-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-surface-600 dark:bg-surface-700 dark:text-white dark:placeholder:text-surface-500">{{ old('ad1', $settings->ad1) }}</textarea>
                        <p class="mt-1.5 text-xs text-surface-500 dark:text-surface-400">HTML or JavaScript code for the first ad section</p>
                    </div>
                </div>

                <!-- Ad Section 2 -->
                <div>
                    <label for="ad2" class="block text-sm font-medium text-surface-700 dark:text-surface-300">Ad Section 2</label>
                    <div class="mt-1">
                        <textarea name="ad2" id="ad2" rows="4" placeholder="Enter HTML or JavaScript code for ad section 2" class="block w-full rounded-md border-surface-300 py-2 text-surface-900 placeholder:text-surface-400 focus:border-indigo-500 focus:ring-indigo-500 dark:border-surface-600 dark:bg-surface-700 dark:text-white dark:placeholder:text-surface-500">{{ old('ad2', $settings->ad2) }}</textarea>
                        <p class="mt-1.5 text-xs text-surface-500 dark:text-surface-400">HTML or JavaScript code for the second ad section</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="button" id="reset-button" class="inline-flex items-center justify-center rounded-lg border border-surface-300 bg-white px-5 py-2.5 text-sm font-medium text-surface-700 shadow-sm hover:bg-surface-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-surface-600 dark:bg-surface-800 dark:text-surface-300 dark:hover:bg-surface-700">
                <i class="ri-refresh-line mr-1.5"></i> Reset
            </button>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-400">
                <i class="ri-save-line mr-1.5"></i> Save Settings
            </button>
        </div>

        <!-- Mobile Save Button -->
        <div class="md:hidden">
            <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-400">
                <i class="ri-save-line mr-1.5"></i> Save Settings
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle for redirect enabled status text
        const redirectToggle = document.getElementById('redirect_enabled');
        const redirectStatus = document.getElementById('redirect_status');
        
        if (redirectToggle && redirectStatus) {
            redirectToggle.addEventListener('change', function() {
                redirectStatus.textContent = this.checked ? 'Enabled' : 'Disabled';
            });
        }
        
        // Custom reset functionality
        const resetButton = document.getElementById('reset-button');
        
        if (resetButton) {
            resetButton.addEventListener('click', function() {
                // Clear input fields
                document.getElementById('active_domain').value = '';
                document.getElementById('ad1').value = '';
                document.getElementById('ad2').value = '';
                
                // Disable toggle button
                if (redirectToggle) {
                    redirectToggle.checked = false;
                    redirectStatus.textContent = 'Disabled';
                }
            });
        }
    });
</script>
@endsection
