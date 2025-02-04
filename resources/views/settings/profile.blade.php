@extends('layouts.app')
@section('title', 'Update Profile')
@section('content')
    <style>
        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-group {
            flex: 1;
            min-width: 0;
        }

        .form-group.flex-1 {
            flex: 1;
        }

        .form-group.flex-2 {
            flex: 2;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 1rem;
            }

            .form-group {
                width: 100%;
                flex: none;
            }
        }
    </style>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <!-- User Section -->
        <div class="mb-6 p-4 bg-white shadow">
            <div class="form-row">
                <!-- Name & Email -->
                <div class="form-group flex-1">
                    <label class="auth-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                </div>
                <div class="form-group flex-1">
                    <label class="auth-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <!-- Password & Confirm -->
                <div class="form-group flex-1">
                    <label class="auth-label">New Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group flex-1">
                    <label class="auth-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Save Profile</button>
    </form>
@endsection
