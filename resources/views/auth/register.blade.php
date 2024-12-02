@extends('layouts.auth')
@section('content')
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf
        <h2 class="auth-header">Register</h2>
        <div style="margin-bottom: 16px;">
            <label for="name" class="auth-label">Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div style="margin-bottom: 16px;">
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div style="margin-bottom: 16px;">
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div style="margin-bottom: 16px;">
            <label for="password-confirm" class="auth-label">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
@endsection
