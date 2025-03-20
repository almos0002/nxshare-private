<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">
      <title>{{ $post->title }}</title>
      <link href="{{ asset('assets/css/display.css') }}" rel="stylesheet">
      <style>
         .cntr {
            max-width: 750px;
            width: 100%;
         }
         .videoplayer {
            position: relative;
            overflow: hidden;
            padding-top: 56.25%;
            margin-bottom: 10px;
         }
         .videoplayer iframe {
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
         }
      </style>
   </head>
   <body>
      <!-- Top Bar -->
      <header class="top-bar">
         <h1>{{ $post->title }}</h1>
         <div style="color:#909090; font-weight:600">
            <span>Views: {{ $post->views }}</span> &#160; | 
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
            <div class="cntr">
               <div class="videoplayer">
                  <iframe title="video" src="{{ $postLinks }}" allowfullscreen scrolling="no"></iframe>
               </div>
               <button class="download-btn" onclick="window.location.href='{{ $postLinks }}'">{{ $emojis[0] }} DOWNLOAD_</button>
            </div>
         </div>
         <div style="display:flex;justify-content:center;margin-top:5px;">{!! $settings->ad1 !!}</div>
      </main>
      <!-- Bottom Bar -->
      <footer class="bottom-bar">
         <button class="social-btn" onclick="window.location.href='https://t.me/NxWall'">🔥 Join Our Telegram Channel 🔥</button><br/>
         <p>Join Our Wallpaper Community in Telegram from the above button. Thank You!!</p>
      </footer>
      {!! $settings->ad2 !!}
   </body>
</html>
