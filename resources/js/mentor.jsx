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
    /*
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
    */

    // Dynamic Module Categories (Create/Edit Module Forms)
    const moduleCategoriesContainer = document.getElementById('module-categories-container');
    const moduleCategoriesContainerEdit = document.getElementById('module-categories-container-edit');

    // Function to update visibility of remove buttons
    const updateRemoveButtons = (container) => {
        const removeButtons = container.querySelectorAll('.remove-category-btn');
        if (container.children.length <= 1) {
            removeButtons.forEach(btn => btn.style.display = 'none');
        } else {
            removeButtons.forEach(btn => btn.style.display = 'block');
        }
    };

    function setupDynamicCategories(containerId, initialCategoriesHtml = '') {
        const container = document.getElementById(containerId);
        if (!container) return;

        // Function to create a new category item
        const createCategoryItem = (selectedValue = '') => {
            const div = document.createElement('div');
            div.classList.add('flex', 'items-center', 'mb-2', 'module-category-item');

            const select = document.createElement('select');
            select.name = 'module_category_ids[]';
            select.classList.add('shadow', 'appearance-none', 'border', 'rounded', 'w-full', 'py-2', 'px-3', 'text-gray-700', 'leading-tight', 'focus:outline-none', 'focus:shadow-outline');
            select.required = true;

            // Clone options from an existing select or use provided html
            let optionsHtml = '<option value="">Pilih Kategori Modul</option>';
            const existingSelect = container.querySelector('select[name="module_category_ids[]"]');
            if (existingSelect) {
                optionsHtml = existingSelect.innerHTML;
            } else if (initialCategoriesHtml) {
                // For edit form where categories might be loaded dynamically if container is empty
                optionsHtml = initialCategoriesHtml; // This will already contain the <option> tags
            }
            select.innerHTML = optionsHtml;
            select.value = selectedValue;

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('ml-2', 'bg-red-500', 'hover:bg-red-600', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded', 'remove-category-btn');
            removeButton.textContent = '-';

            div.appendChild(select);
            div.appendChild(removeButton);

            return div;
        };

        // Event listener for adding new category fields (on the add button)
        container.addEventListener('click', function (event) {
            if (event.target.classList.contains('add-category-btn')) {
                const newCategoryItem = createCategoryItem();
                container.appendChild(newCategoryItem);
                updateRemoveButtons(container); // Update visibility after adding
            } else if (event.target.classList.contains('remove-category-btn')) {
                if (container.children.length > 1) { // Ensure at least one field remains
                    event.target.parentNode.remove();
                    updateRemoveButtons(container); // Update visibility after removing
                }
            }
        });

        // For edit form, if no items are pre-filled by Blade (e.g., old() returns empty, module has no categories),
        // we add one empty item for user to start with.
        if (container.id === 'module-categories-container-edit' && container.children.length === 0) {
            // Get options from the data-options attribute set in Blade
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = container.dataset.options; // This will be the <select> element with all options
            const optionsOnly = tempDiv.querySelector('select').innerHTML;
            const newCategoryItem = createCategoryItem('', optionsOnly); // Pass options to new item
            container.appendChild(newCategoryItem);
        }
        updateRemoveButtons(container); // Initial update on load
    }

    if (moduleCategoriesContainer) {
        setupDynamicCategories('module-categories-container');
    }
    if (moduleCategoriesContainerEdit) {
        // For edit form, the Blade loop already populates initial categories.
        // We just need to attach event listeners and ensure initial state is correct.
        // The `dataset.options` in edit.blade.php should contain all category options for new dynamic selects.
        const optionsHtmlForNewSelects = moduleCategoriesContainerEdit.dataset.options;
        setupDynamicCategories('module-categories-container-edit', optionsHtmlForNewSelects);
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
