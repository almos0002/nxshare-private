@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <div class="dashboard-container">
        <!-- Stats Section -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="ri-file-text-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Total Posts</h3>
                        <p id="total-posts">{{ number_format($totalPosts) }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: var(--secondary)">
                        <i class="ri-eye-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Total Views</h3>
                        <p id="total-views">{{ number_format($totalViews) }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: #10B981">
                        <i class="ri-user-3-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Logged In User</h3>
                        <p>{{ $userName }}</p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: #F59E0B">
                        <i class="ri-shield-check-line"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Redirect Status</h3>
                        <p>{{ $redirectEnabled }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Sections -->
        <div class="content-wrapper">
            <div class="content-box">
                <div class="content-header">
                    <i class="ri-fire-line"></i>
                    <h2>Top Viewed Posts</h2>
                </div>
                <ul class="dash-post-list" id="most-viewed-list">
                    @foreach($mostViewed as $post)
                    <li class="dash-post-item">
                        <a href="/{{ $post->type == 'i' ? 'i' : ($post->type == 'n' ? 'n' : ($post->type == 'w' ? 'w' : ($post->type == 'p' ? 'p' : 'v'))) }}/{{ $post->slug }}" class="dash-post-link">
                            <span class="dash-post-title">{{ $post->title }}</span>
                            <span class="dash-post-meta">
                                <i class="ri-eye-line"></i>
                                {{ number_format($post->views) }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="content-box">
                <div class="content-header">
                    <i class="ri-time-line"></i>
                    <h2>Recent Posts</h2>
                </div>
                <ul class="dash-post-list" id="recent-posts-list">
                    @foreach($recentPosts as $post)
                    <li class="dash-post-item">
                        <a href="/{{ $post->type == 'i' ? 'i' : ($post->type == 'n' ? 'n' : ($post->type == 'w' ? 'w' : ($post->type == 'p' ? 'p' : 'v'))) }}/{{ $post->slug }}" class="dash-post-link">
                            <span class="dash-post-title">{{ $post->title }}</span>
                            <span class="dash-post-meta">
                                <i class="ri-calendar-line"></i>
                                {{ $post->created_at->format('M j') }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection