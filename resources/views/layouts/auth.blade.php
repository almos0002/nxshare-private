<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
        <link href="{{asset('assets')}}/css/style.css" rel="stylesheet">
        <title>{{'Log In'}}</title>
    </head>
    <body style="background-color: var(--neutral-50); display: flex; justify-content: center; align-items: center; height: 100vh;">
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/@floating-ui/core@1.6.8"></script>
        <script src="https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.6.12"></script>
        <script src="{{asset('assets')}}/js/script.js"></script>
    </body>
</html>
