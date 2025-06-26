<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Platform modul pembelajaran untuk Santri Pondok IT">
    <title>@yield('title', 'Modul Pembelajaran Santri Pondok IT')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    <x-navbar/>

    <main class="flex-grow pt-6 pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Session Notifications --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm mb-6" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Modul Pembelajaran</h3>
                    <p class="text-sm text-gray-400">
                        Platform untuk membuat, mengelola, membaca, dan mengunduh modul pembelajaran bagi santri Pondok IT.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Menu</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('santri.home') }}" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('santri.modules.index') }}" class="text-gray-400 hover:text-white transition-colors">Modul</a></li>
                        <li><a href="{{ route('santri.about') }}" class="text-gray-400 hover:text-white transition-colors">Tentang</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Kontak</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center">
                            <i class="fas fa-envelope w-5 text-gray-500"></i>
                            <span class="ml-2 text-gray-400">info.pondokit@gmail.com </span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone w-5 text-gray-500"></i>
                            <span class="ml-2 text-gray-400">(+62) 895-2800-2800</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt w-5 text-gray-500"></i>
                            <span class="ml-2 text-gray-400">Desa tirtohargo dsn kalangan, RT./RW/RW.01/00, Gegunung, Yogyakarta, Daerah Istimewa Yogyakarta 55772, Indonesia</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Modul Pembelajaran Santri Pondok IT. All rights reserved.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="https://www.instagram.com/pondokitofficial/" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/pondokit?locale=id_ID" target="_blank" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <div id="chatbot-root"></div>
    <script defer src="https://unpkg.com/alpinejs@3.14.9/dist/cdn.min.js"></script>
    @vite('resources/js/components/Chatbot.jsx')
    @stack('scripts')
</body>
</html>
