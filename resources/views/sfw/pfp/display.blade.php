<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">
    <title>{{ $post->title }}</title>
    <link href="{{ asset('assets') }}/css/display.css" rel="stylesheet">
    <style>
        .main-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <h1>{{ $post->title }}</h1>
        <div style="color:#909090; font-weight:600">
            <span>Views: {{ $post->views }}</span>&#160; |
            <span>Date: {{ $post->created_at->format('Y-m-d') }}</span>
        </div>
    </header>
    <!-- Main Content -->
    <main class="main-content">
        <div style="display:flex;justify-content:center">{!! $settings->ad1 !!}</div>
        <div class="flex-container">
            @php
                $emojis = ['♨️', '💢', '🪱'];
                shuffle($emojis);
            @endphp
            @foreach ($postLinks as $index => $link)
                <div class="flex-item">
                    <img src="{{ preg_replace('/(\.[^.]+)$/', '.md$1', $link) }}" alt="PFP {{ $index + 1 }}">
                    <button class="download-btn"
                        onclick="window.location.href='{{ $link }}'">{{ $emojis[$index % count($emojis)] }}
                        DOWNLOAD_</button>
                </div>
            @endforeach
        </div>
        <div style="display:flex;justify-content:center;margin-top:5px;">{!! $settings->ad1 !!}</div>
    </main>
    <!-- Bottom Bar -->
    <footer class="bottom-bar">
        <button class="social-btn" onclick="window.location.href='https://t.me/NxWall'">🔥 Join Our Telegram Channel
            🔥</button><br />
        <p>Join Our Profile Picture Community in telegram from the above button. Thank You!!</p>
    </footer>
    {!! $settings->ad2 !!}
</body>

</html>
