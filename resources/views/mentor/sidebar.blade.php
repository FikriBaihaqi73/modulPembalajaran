<div id="sidebar" class="fixed z-30 inset-y-0 left-0 bg-gray-900 overflow-y-auto transform transition-all duration-300 ease-in-out lg:static lg:inset-auto lg:translate-x-0 w-64 lg:w-20 lg:hover:w-64 sidebar-expanded-width">
    <div class="flex items-center justify-between px-6 py-4">
        <a href="#" class="text-white text-2xl font-semibold uppercase whitespace-nowrap overflow-hidden">
            <span id="mentor-panel-text" class="transition-opacity duration-300">Mentor Panel</span>
        </a>
        <button id="sidebarClose" class="text-gray-500 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
        <button id="sidebarToggleDesktop" class="text-gray-500 focus:outline-none hidden lg:block ml-auto">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M13 18L7 12L13 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </button>
    </div>

    <nav class="mt-10">
        <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 group" href="{{ url('/mentor/dashboard') }}">
            <svg class="h-6 w-6 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12H12M12 12V3M12 12V21M21 12H12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Dashboard</span>
        </a>
        <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 group" href="{{ route('mentor.module-categories.index') }}">
            <svg class="h-6 w-6 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 3H14V7H10V3ZM17 3H21V7H17V3ZM3 10H7V14H3V10ZM10 10H14V14H10V10ZM17 10H21V14H17V10ZM3 17H7V21H3V17ZM10 17H14V21H10V17ZM17 17H21V21H17V17Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Kategori Modul</span>
        </a>
        <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 group" href="{{ route('mentor.modules.index') }}">
            <svg class="h-6 w-6 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8 5H16C17.1046 5 18 5.89543 18 7V17C18 18.1046 17.1046 19 16 19H8C6.89543 19 6 18.1046 6 17V7C6 5.89543 6.89543 5 8 5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10 3H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Modul Pembelajaran</span>
        </a>
        <!-- Add more mentor-specific navigation links here -->
    </nav>
</div>
