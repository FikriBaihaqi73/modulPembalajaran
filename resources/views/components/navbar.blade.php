<nav x-data="{ mobileMenuOpen: false }" class="bg-white shadow-md sticky top-0 z-50">
    <style>
        .notification-bell {
            transition: all 0.2s ease;
        }
        .notification-bell:hover {
            transform: scale(1.1);
        }
        .notification-badge {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(0.95);
            }
            70% {
                transform: scale(1);
            }
            100% {
                transform: scale(0.95);
            }
        }
    </style>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex items-center">
                    <span class="text-xl font-bold text-blue-600 mr-1">Modul</span>
                    <span class="text-xl font-medium text-gray-800">Pembelajaran</span>
                </a>
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="/" class="group relative text-gray-700 hover:text-blue-600 py-5 text-sm font-medium transition-colors duration-200 {{ request()->is('/') ? 'text-blue-600' : '' }}">
                    Beranda
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full {{ request()->is('/') ? 'w-full' : '' }}"></span>
                </a>
                <a href="{{ route('santri.modules.index') }}" class="group relative text-gray-700 hover:text-blue-600 py-5 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('santri.modules.index') || request()->routeIs('santri.modules.show') ? 'text-blue-600' : '' }}">
                    Modul
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full {{ request()->routeIs('santri.modules.index') || request()->routeIs('santri.modules.show') ? 'w-full' : '' }}"></span>
                </a>
                <a href="/about" class="group relative text-gray-700 hover:text-blue-600 py-5 text-sm font-medium transition-colors duration-200 {{ request()->is('about') ? 'text-blue-600' : '' }}">
                    Tentang
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full {{ request()->is('about') ? 'w-full' : '' }}"></span>
                </a>

                @guest
                    <div class="flex items-center ml-4">
                        <a href="/login" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </a>
                    </div>
                @endguest

                @auth
                    <div x-data="{ open: false }" class="relative flex items-center ml-4"> {{-- Added flex items-center here --}}
                        {{-- Notification Bell Icon --}}
                        <a href="{{ route('santri.notifications.index') }}" class="notification-bell relative text-gray-700 hover:text-blue-600 focus:outline-none mr-4 p-1.5 rounded-full hover:bg-blue-50 transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full flex items-center justify-center min-w-[20px] h-5">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <button @click="open = !open" @click.outside="open = false" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 focus:outline-none">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="ml-2 text-sm font-medium">{{ Auth::user()->name }}</span>
                                <svg :class="{'rotate-180': open}" class="ml-1 h-5 w-5 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200" style="display: none;">
                            @if(Auth::user()->role->name === 'Admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                                    Dashboard
                                </a>
                            @elseif(Auth::user()->role->name === 'Mentor')
                                <a href="{{ route('mentor.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                                    Dashboard
                                </a>
                            @elseif(Auth::user()->role->name === 'Santri')
                                <a href="{{ route('santri.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2 text-gray-500"></i>
                                    Profil
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <div class="flex items-center md:hidden">
                @auth
                    <a href="{{ route('santri.notifications.index') }}" class="notification-bell relative text-gray-700 hover:text-blue-600 focus:outline-none mr-4 p-1.5 rounded-full hover:bg-blue-50 transition-colors">
                        <i class="fas fa-bell text-xl"></i>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                            <span class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full flex items-center justify-center min-w-[20px] h-5">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                @endauth
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" style="display: none;" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileMenuOpen" class="md:hidden" id="mobile-menu" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 border-t">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600 {{ request()->is('/') ? 'bg-blue-50 text-blue-600' : '' }}">
                Beranda
            </a>
            <a href="{{ route('santri.modules.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600 {{ request()->routeIs('santri.modules.index') || request()->routeIs('santri.modules.show') ? 'bg-blue-50 text-blue-600' : '' }}">
                Modul
            </a>
            <a href="/about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600 {{ request()->is('about') ? 'bg-blue-50 text-blue-600' : '' }}">
                Tentang
            </a>

            @guest
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <a href="/login" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Login
                    </a>
                </div>
            @else
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->role->name }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        {{-- Mobile Notification Link --}}
                        <a href="{{ route('santri.notifications.index') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                            <i class="fas fa-bell mr-2 text-gray-500"></i>
                            Notifikasi
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        @if(Auth::user()->role->name === 'Admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                                <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                                Dashboard
                            </a>
                        @elseif(Auth::user()->role->name === 'Mentor')
                            <a href="{{ route('mentor.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                                <i class="fas fa-tachometer-alt mr-2 text-gray-500"></i>
                                Dashboard
                            </a>
                        @elseif(Auth::user()->role->name === 'Santri')
                            <a href="{{ route('santri.profile') }}" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                                <i class="fas fa-user mr-2 text-gray-500"></i>
                                Profil
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-blue-600">
                                <i class="fas fa-sign-out-alt mr-2 text-gray-500"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</nav>
