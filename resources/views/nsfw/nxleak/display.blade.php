<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">
      <title>{{ $post->title }}</title>
      <link href="{{asset('assets')}}/css/display.css" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
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
         <div style="text-align:center">{!! $settings->ad1 !!}</div>
        <h3>🗃️ Backup Files before it expires ️</h3><br>
        <h1>👇 Enjoy Your Mega Links Now  👇</h1><br>
        {!! $postContent !!}<br>
        <span style="font-size:17px; font-weight:600">Hey You 🫵, Yes you!! Don't Fap 💦 a lot buddy 😉</span><br><br>
        <i style="font-size:18px;">⚠️ Don't forget to join our telegram channel to get notified about new contents instantly!</i>
        <div>
        <button class="download-btn" onclick="window.location.href='https://t.me/nxleak'">😈TELEGRAM OFFICIAL_</button>
        <button class="download-btn" onclick="window.location.href='https://t.me/nxleak'">💦TELEGRAM NEW_</button>
        <button class="download-btn" onclick="window.location.href='https://t.me/nxleak'">🌐VISIT WEBSITE_</button>
        </div>
        <div style="text-align:center">{!! $settings->ad1 !!}</div>
      </main>
      <!-- Bottom Bar -->
      <footer class="bottom-bar">
         <button
            class="social-btn"
            onclick="window.location.href='https://t.me/NxWall'"
            >
         🔥 Report Broken Link 🔥</button
            ><br />
         <p>
            If any link is not working then please report us we will try to fix that link within 2-3 days. Thank You!!
         </p>
      </footer>
      {!! $settings->ad2 !!}
   </body>
</html>