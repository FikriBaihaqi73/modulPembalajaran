<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <link rel="icon" href="{{ asset('android-chrome-512x512.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/mentor.jsx'])
</head>
<body>
    <div id="app-layout" class="flex h-screen bg-gray-100 sidebar-expanded">
        <!-- Sidebar -->
        @include('mentor.sidebar')

        <!-- Page Content -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300">
            <header class="flex items-center justify-between px-6 py-4 bg-white">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="text-gray-500 focus:outline-none md:hidden border-none outline-none bg-transparent">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center">
                    <div id="profileDropdown" class="relative ml-4">
                        <button id="profileDropdownToggle" class="flex items-center text-gray-500 hover:text-gray-700 focus:outline-none border-none outline-none bg-transparent">
                            <span class="mr-2 text-sm text-gray-600">Mentor</span>
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </button>

                        <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">
                                    Log out
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @yield('scripts')
</body>
</html>
