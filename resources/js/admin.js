document.addEventListener('DOMContentLoaded', function () {
    // Sidebar functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    if (sidebarToggle && sidebar && sidebarClose) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        });

        sidebarClose.addEventListener('click', function () {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        });

        // Close sidebar when clicking outside on small screens
        document.addEventListener('click', function (event) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && window.innerWidth < 1024) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            }
        });
    }

    // Dropdown functionality
    const profileDropdownToggle = document.getElementById('profileDropdownToggle');
    const profileDropdownMenu = document.getElementById('profileDropdownMenu');

    if (profileDropdownToggle && profileDropdownMenu) {
        profileDropdownToggle.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent document click listener from closing it immediately
            profileDropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!profileDropdownMenu.contains(event.target) && !profileDropdownToggle.contains(event.target)) {
                profileDropdownMenu.classList.add('hidden');
            }
        });
    }
});
