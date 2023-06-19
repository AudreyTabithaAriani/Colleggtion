<!DOCTYPE html>
<html lang="en">
        <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta http-equiv="X-UA-Compatible" content="ie=edge">
                <title>{{ $pageTitle }}</title>
                <link href="style/cdn.jsdelivr.net_npm_daisyui%403.0.20_dist_full.css" rel="stylesheet" type="text/css" />
                <script src="style/cdn.tailwindcss.com_3.3.2.js"></script>

                <link rel="icon" href="{{ asset($system->gameIcon) }}">
        </head>
        <body data-theme="luxury">
                <header class="sticky top-0 z-50">
                        @yield("header")
                </header>
                <main class="bg-base">
                        @yield("content")
                </main>
                <footer>
                        @yield("footer")
                </footer>
        </body>
</html>
