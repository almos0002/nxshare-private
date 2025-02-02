@extends('layouts.app') @section('content')
<form method="POST" action="{{ route('settings.update') }}"> @csrf <div class="mb-4">
    <label>Active Domain</label>
    <input type="url" name="active_domain" value="{{ old('active_domain', $settings->active_domain) }}" class="form-control">
  </div>
  <div class="mb-4">
    <label class="flex items-center">
      <input type="hidden" name="redirect_enabled" value="0">
      <input type="checkbox" name="redirect_enabled" value="1" @checked(old('redirect_enabled', $settings->redirect_enabled))> <span class="ml-2">Enable Redirects</span>
    </label>
  </div>
  <button type="submit" class="btn btn-primary">Save Settings</button>
</form>@endsection