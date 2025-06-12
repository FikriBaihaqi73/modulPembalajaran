import React from 'react';
import ReactDOM from 'react-dom/client';

document.addEventListener('DOMContentLoaded', function () {
    // Sidebar functionality (assuming a similar sidebar structure to admin)
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const appLayout = document.getElementById('app-layout');

    if (sidebarToggle && sidebar && sidebarClose && appLayout) {
        // Initial state based on screen size
        function setSidebarInitialState() {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('-translate-x-full');
                appLayout.classList.remove('sidebar-expanded');
                appLayout.classList.add('sidebar-collapsed');
            } else {
                sidebar.classList.remove('-translate-x-full');
                appLayout.classList.remove('sidebar-collapsed');
                appLayout.classList.add('sidebar-expanded');
            }
        }

        setSidebarInitialState();
        window.addEventListener('resize', setSidebarInitialState);

        // Toggle sidebar on mobile
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            appLayout.classList.remove('sidebar-collapsed');
            appLayout.classList.add('sidebar-expanded');
        });

        // Close sidebar on mobile
        sidebarClose.addEventListener('click', function () {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            appLayout.classList.remove('sidebar-expanded');
            appLayout.classList.add('sidebar-collapsed');
        });

        // Close sidebar when clicking outside on small screens
        document.addEventListener('click', function (event) {
            if (window.innerWidth < 1024 && !sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                appLayout.classList.remove('sidebar-expanded');
                appLayout.classList.add('sidebar-collapsed');
            }
        });

        // Desktop sidebar toggle (if applicable)
        const sidebarToggleDesktop = document.getElementById('sidebarToggleDesktop');
        if (sidebarToggleDesktop) {
            sidebarToggleDesktop.addEventListener('click', function() {
                appLayout.classList.toggle('sidebar-expanded');
                appLayout.classList.toggle('sidebar-collapsed');
            });
        }
    }

    // Dropdown functionality (assuming similar profile dropdown to admin)
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

    // Tiptap Editor Initialization
    const editorRoot = document.getElementById('tiptap-editor');
    const hiddenInput = document.getElementById('content-hidden');
    const moduleForm = document.getElementById('moduleForm');

    if (moduleForm) {
        moduleForm.addEventListener('submit', function (event) {
            // Only prevent default if the actual submit button was not clicked
            // This prevents auto-submit when Tiptap's image upload input is triggered
            if (document.activeElement !== this.querySelector('button[type="submit"]')) {
                event.preventDefault();
            }
        });
    }

    if (editorRoot && hiddenInput) {
        import('./components/TiptapEditor').then(({ default: TiptapEditor }) => {
            const initialContent = hiddenInput.value;
            ReactDOM.createRoot(editorRoot).render(
                <React.StrictMode>
                    <TiptapEditor
                        content={initialContent}
                        onUpdate={(html) => {
                            hiddenInput.value = html;
                        }}
                    />
                </React.StrictMode>
            );
        }).catch(error => {
            console.error("Failed to load TiptapEditor component:", error);
        });
    }
});
