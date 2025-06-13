<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Modul Pembelajaran Santri Pondok IT')</title>
    <link rel="icon" href="{{ asset('android-chrome-512x512.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col min-h-screen">
    <x-navbar/>

    <div class="container mx-auto mt-10 flex-grow">
        @yield('content')
    </div>

    <footer class="bg-gray-800 text-white text-center p-4 mt-auto">
        <p>&copy;{{ date('Y') }} Modul Pembelajaran Santri Pondok IT. All rights reserved.</p>
    </footer>
</body>
</html>
