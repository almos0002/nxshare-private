@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf
        <h2 class="auth-header">Login</h2>
        <div style="margin-bottom: 16px;">
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div style="margin-bottom: 16px;">
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="auth-rem">
            <label>
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>&#160;Remember me
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="auth-a">Forgot Password?</a>
            @endif
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection
