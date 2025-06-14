<div id="sidebar" class="fixed z-30 inset-y-0 left-0 bg-gradient-to-b from-blue-600 to-indigo-800 overflow-y-auto transform transition-all duration-300 ease-in-out lg:static lg:inset-auto lg:translate-x-0 w-64 lg:w-20 lg:hover:w-64 sidebar-expanded-width">
    <div class="flex items-center justify-between px-6 py-4 border-b border-blue-500">
        <a href="#" class="text-white text-xl font-semibold uppercase whitespace-nowrap overflow-hidden">
            <span id="mentor-panel-text" class="transition-opacity duration-300">Mentor Panel</span>
        </a>
        <button id="sidebarClose" class="text-blue-300 hover:text-white focus:outline-none lg:hidden transition-colors">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        <button id="sidebarToggleDesktop" class="text-blue-300 hover:text-white focus:outline-none hidden lg:block ml-auto transition-colors">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 18L7 12L13 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
    </div>

    <nav class="mt-6 px-4">
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ url('/') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 9L12 2L21 9V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M9 13V17H15V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Beranda</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ url('/mentor/dashboard') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12H12M12 12V3M12 12V21M21 12H12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Dashboard</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ route('mentor.module-categories.index') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 3H14V7H10V3ZM17 3H21V7H17V3ZM3 10H7V14H3V10ZM10 10H14V14H10V10ZM17 10H21V14H17V10ZM3 17H7V21H3V17ZM10 17H14V21H10V17ZM17 17H21V21H17V17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Kategori Modul</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ route('mentor.modules.index') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 5H16C17.1046 5 18 5.89543 18 7V17C18 18.1046 17.1046 19 16 19H8C6.89543 19 6 18.1046 6 17V7C6 5.89543 6.89543 5 8 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10 3H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Modul Pembelajaran</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ route('mentor.santri.index') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4C14.2091 4 16 5.79086 16 8C16 10.2091 14.2091 12 12 12C9.79086 12 8 10.2091 8 8C8 5.79086 9.79086 4 12 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M4 20V17C4 15.3431 5.34315 14 7 14H17C18.6569 14 20 15.3431 20 17V20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Manajemen Santri</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ route('mentor.module-progress.index') }}">
            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13m-6 3H9M12 19V6m-6 3H3v9l9 3V9m5.75-.75V5.25A2.25 2.25 0 0018 3h.25a2.25 2.25 0 002.25 2.25v1.51M12 12l.375.375M12 15l3 3m-3-3V7.5M12 12l-3-3m-3 3l.375.375M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Lacak Kemajuan Modul</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all {{ request()->routeIs('mentor.announcements.*') ? 'bg-blue-700 bg-opacity-50 text-white' : '' }}" href="{{ route('mentor.announcements.index') }}">
            <i class="fas fa-bullhorn flex-shrink-0 w-5 h-5 transition duration-75 group-hover:text-white {{ request()->routeIs('mentor.announcements.*') ? 'text-white' : '' }}"></i>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Pengumuman</span>
        </a>
    </nav>
</div>
