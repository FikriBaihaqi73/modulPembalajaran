<div id="sidebar" class="fixed z-30 inset-y-0 left-0 bg-gradient-to-b from-blue-800 to-indigo-900 overflow-y-auto transform transition-all duration-300 ease-in-out lg:static lg:inset-auto lg:translate-x-0 w-64 lg:w-20 lg:hover:w-64 sidebar-expanded-width">
    <div class="flex items-center justify-between px-6 py-4 border-b border-blue-700">
        <a href="#" class="text-white text-xl font-semibold uppercase whitespace-nowrap overflow-hidden">
            <span id="admin-panel-text" class="transition-opacity duration-300">Admin Panel</span>
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
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ url('/admin/dashboard') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12H12M12 12V3M12 12V21M21 12H12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Dashboard</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ url('/admin/santri') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 21H7C4.79 21 3 19.21 3 17V7C3 4.79 4.79 3 7 3H17C19.21 3 21 4.79 21 7V17C21 19.21 19.21 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 14C8.68629 14 6 16.6863 6 20H18C18 16.6863 15.3137 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Santri Management</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ url('/admin/mentor') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 21H7C4.79 21 3 19.21 3 17V7C3 4.79 4.79 3 7 3H17C19.21 3 21 4.79 21 7V17C21 19.21 19.21 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 14C8.68629 14 6 16.6863 6 20H18C18 16.6863 15.3137 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Mentor Management</span>
        </a>
        <a class="flex items-center py-3 px-4 rounded-lg text-gray-100 hover:bg-blue-700 hover:bg-opacity-50 hover:text-white group mb-3 transition-all" href="{{ url('/admin/modules') }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 5H16C17.1046 5 18 5.89543 18 7V17C18 18.1046 17.1046 19 16 19H8C6.89543 19 6 18.1046 6 17V7C6 5.89543 6.89543 5 8 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10 3H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm font-medium transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Module Management</span>
        </a>
    </nav>
</div>
