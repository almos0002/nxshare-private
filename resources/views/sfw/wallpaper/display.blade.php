<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="https://i.postimg.cc/4dbDJLpG/favicon.png">
      <title>{{ $post->title }}</title>
      <style>
         @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
         * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         }
         body {
         font-family: "Barlow Condensed", sans-serif;
         }
         .top-bar {
         background-color: #f5f5f5;
         color: #000;
         text-align: center;
         padding: 20px;
         }
         .top-bar h1 {
         font-size: 2rem;
         }
         .main-content {
         padding: 20px;
         text-align: center;
         }
         .flex-container {
         display: flex;
         flex-wrap: wrap;
         justify-content: center;
         gap: 20px;
         }
         .flex-item {
         flex: 1 1 calc(250px - 20px);
         max-width: 220px;
         text-align: center;
         }
         .flex-item img {
         width: 100%;
         height: auto;
         border-radius: 8px;
         }
         .flex-item button {
         background-color: #000;
         font-family: "Barlow Condensed", sans-serif;
         font-size: 18px;
         font-weight: 600;
         color: white;
         padding: 10px 25px;
         border: none;
         cursor: pointer;
         margin-top: 10px;
         }
         .flex-item button:hover {
         background-color: #000;
         }
         .social-btn{
         background-color: #fff;
         font-family: "Barlow Condensed", sans-serif;
         font-size: 18px;
         font-weight: 600;
         color: #000;
         padding: 10px 25px;
         border: none;
         cursor: pointer;
         margin-top: 10px;
         margin-bottom:10px;
         }
         .bottom-bar {
         background-color: #000;
         color: white;
         text-align: center;
         padding: 10px;
         width: 100%;
         bottom: 0;
         }
         .bottom-bar p {
         font-size: 1rem;
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
         <div class="flex-container">
            @php
            $emojis = ['♨️', '💢', '🪱'];
            shuffle($emojis);
            @endphp
            @foreach ($postLinks as $index => $link)
            <div class="flex-item">
               <img src="{{ $link }}" alt="Wallpaper {{ $index + 1 }}">
               <button class="download-btn" onclick="window.location.href='{{ $link }}'">{{ $emojis[$index % count($emojis)] }} DOWNLOAD_</button>
            </div>
            @endforeach
         </div>
      </main>
      <!-- Bottom Bar -->
      <footer class="bottom-bar">
         <button class="social-btn" onclick="window.location.href='https://t.me/NxWall'">🔥 Join Our Telegram Channel 🔥</button><br/>
         <p>Join Our Wallpaper Community in telegram from the above button. Thank You!!</p>
      </footer>
   </body>
</html>