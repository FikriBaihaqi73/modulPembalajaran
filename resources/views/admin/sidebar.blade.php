<div id="sidebar" class="fixed z-30 inset-y-0 left-0 bg-gray-900 overflow-y-auto transform transition-all duration-300 ease-in-out lg:static lg:inset-auto lg:translate-x-0 w-64 lg:w-20 lg:hover:w-64 sidebar-expanded-width">
    <div class="flex items-center justify-between px-6 py-4">
        <a href="#" class="text-white text-2xl font-semibold uppercase whitespace-nowrap overflow-hidden">
            <span id="admin-panel-text" class="transition-opacity duration-300">Admin Panel</span>
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
        <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 group" href="{{ url('/admin/dashboard') }}">
            <svg class="h-6 w-6 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12H12M12 12V3M12 12V21M21 12H12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Dashboard</span>
        </a>
        <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 group" href="{{ url('/admin/santri') }}">
            <svg class="h-6 w-6 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 21H7C4.79 21 3 19.21 3 17V7C3 4.79 4.79 3 7 3H17C19.21 3 21 4.79 21 7V17C21 19.21 19.21 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 14C8.68629 14 6 16.6863 6 20H18C18 16.6863 15.3137 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Santri Management</span>
        </a>
        <a class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100 group" href="{{ url('/admin/mentor') }}">
            <svg class="h-6 w-6 flex-shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 21H7C4.79 21 3 19.21 3 17V7C3 4.79 4.79 3 7 3H17C19.21 3 21 4.79 21 7V17C21 19.21 19.21 21 17 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M12 14C8.68629 14 6 16.6863 6 20H18C18 16.6863 15.3137 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <span class="mx-3 text-sm transition-opacity duration-300 opacity-100 whitespace-nowrap overflow-hidden group-[.sidebar-collapsed-text]:opacity-0">Mentor Management</span>
        </a>
    </nav>
</div>
