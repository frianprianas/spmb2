<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'SPMB') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <!-- Tailwind CSS CDN for immediate styling -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Scripts -->
        @routes
        {{-- Production Build (Always use built assets) --}}
        @php
            $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            $appJs = $manifest['resources/js/app.js']['file'];
            if (isset($manifest['resources/js/app.js']['css'])) {
                foreach ($manifest['resources/js/app.js']['css'] as $css) {
                    echo '<link rel="stylesheet" href="' . asset('build/' . $css) . '">';
                }
            }
        @endphp
        <script type="module" src="{{ asset('build/' . $appJs) }}"></script>
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
