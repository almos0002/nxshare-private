@extends('layouts.auth')
@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf
        <h2 class="auth-header">Reset Password</h2>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div style="margin-bottom: 16px;">
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
    </form>
@endsection
