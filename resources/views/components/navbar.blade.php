<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-white text-2xl font-bold">Modul Pembelajaran Santri</a>
        <div>
            <a href="/" class="group relative text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->is('/') ? 'text-blue-500' : '' }}">
                Home
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full {{ request()->is('/') ? 'w-full' : '' }}"></span>
            </a>
            <a href="/about" class="group relative text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->is('about') ? 'text-blue-500' : '' }}">
                About
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full {{ request()->is('about') ? 'w-full' : '' }}"></span>
            </a>
            <a href="/modules" class="group relative text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium {{ request()->is('modules') ? 'text-blue-500' : '' }}">
                Module
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-500 transition-all duration-300 group-hover:w-full {{ request()->is('modules') ? 'w-full' : '' }}"></span>
            </a>
            <a href="/login" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
        </div>
    </div>
</nav>
