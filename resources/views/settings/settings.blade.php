@extends('layouts.app')
@section('content')
    <style>
        .form-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .checkbox.style-e {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
        }

        .checkbox.style-e input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .checkbox.style-e .checkbox__checkmark {
            position: relative;
            width: 40px;
            height: 22px;
            background-color: #eee;
            border-radius: 11px;
            transition: background-color 0.25s;
        }

        .checkbox.style-e input:checked~.checkbox__checkmark {
            background-color: #6366f1;
        }

        .checkbox.style-e .checkbox__checkmark::after {
            content: "";
            position: absolute;
            left: 3px;
            top: 3px;
            width: 16px;
            height: 16px;
            background-color: #fff;
            border-radius: 50%;
            transition: left 0.25s;
        }

        .checkbox.style-e input:checked~.checkbox__checkmark::after {
            left: 21px;
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>

    <form method="POST" action="{{ route('settings.update') }}">
        @csrf

        <div class="mb-6 p-4 bg-white shadow">
            <div class="form-row">
                <div class="form-group">
                    <label class="auth-label">Active Domain</label>
                    <input type="url" name="active_domain" value="{{ old('active_domain', $settings->active_domain) }}"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label class="auth-label">Enable Redirects</label>
                    <label class="checkbox style-e">
                        <input type="hidden" name="redirect_enabled" value="0">
                        <input type="checkbox" name="redirect_enabled" value="1" @checked(old('redirect_enabled', $settings->redirect_enabled))>
                        <div class="checkbox__checkmark"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="mb-6 p-4 bg-white shadow">
            <div class="form-row">
                <div class="form-group">
                    <label class="auth-label">Ad Section 1</label>
                    <textarea name="ad1" class="form-control h-32 w-full" style="height: 100px">{{ old('ad1', $settings->ad1) }}</textarea>
                </div>

                <div class="form-group mt-4">
                    <label class="auth-label">Ad Section 2</label>
                    <textarea name="ad2" class="form-control h-32 w-full" style="height: 100px">{{ old('ad2', $settings->ad2) }}</textarea>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
@endsection
