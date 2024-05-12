<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="fixed top-0 left-0 w-full h-screen font-sans antialiased text-white bg-slate-950">
    <div class="flex items-start justify-start w-full h-full divide-x divide-slate-800/50">
        <livewire:layout.navigation />
        <div class="w-full h-full grow">
            {{ $slot }}
        </div>
    </div>
</body>

</html>