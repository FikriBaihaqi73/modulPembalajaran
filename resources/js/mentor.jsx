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

    // --- Logic for saving/loading module form data to/from localStorage ---

    // Get current module ID if on edit page
    const moduleIdElement = document.querySelector('input[name="module_id"]'); // Assuming module_id hidden input exists
    const currentModuleId = moduleIdElement ? moduleIdElement.value : null;
    console.log('Current Module ID:', currentModuleId);

    // Determine localStorage key based on page (create or edit specific module)
    const unsavedDataKey = currentModuleId ? `unsavedModuleData_${currentModuleId}` : 'unsavedModuleData_create';
    console.log('LocalStorage Key:', unsavedDataKey);

    const moduleNameInput = document.getElementById('name');
    const hiddenContentInput = document.getElementById('content-hidden'); // Tiptap content
    const moduleForm = document.getElementById('moduleForm');

    // Function to save form data to localStorage
    function saveModuleFormData() {
        if (!moduleNameInput || !moduleForm) {
            console.log('saveModuleFormData: Module form elements not found.');
            return; // Ensure elements exist on the page
        }

        const currentData = JSON.parse(localStorage.getItem(unsavedDataKey)) || {};
        currentData.name = moduleNameInput.value;

        // Collect category IDs
        const categoriesContainer = currentModuleId ? moduleCategoriesContainerEdit : moduleCategoriesContainer;
        if (categoriesContainer) {
            const selectedCategories = Array.from(categoriesContainer.querySelectorAll('select[name="module_category_ids[]"]'))
                .map(select => select.value)
                .filter(value => value !== ''); // Only save selected non-empty categories
            currentData.categories = selectedCategories;
        }

        localStorage.setItem(unsavedDataKey, JSON.stringify(currentData));
        console.log('Saved unsavedModuleData:', currentData);
    }

    // Function to load form data from localStorage
    function loadModuleFormData() {
        if (!moduleNameInput || !moduleForm) {
            console.log('loadModuleFormData: Module form elements not found.');
            return; // Ensure elements exist on the page
        }

        const savedData = JSON.parse(localStorage.getItem(unsavedDataKey));
        console.log('Loaded savedData:', savedData);

        if (savedData) {
            if (savedData.name !== undefined) {
                moduleNameInput.value = savedData.name;
                console.log('Loaded module name:', savedData.name);
            }

            // Load categories
            const categoriesContainer = currentModuleId ? moduleCategoriesContainerEdit : moduleCategoriesContainer;
            if (categoriesContainer && savedData.categories && savedData.categories.length > 0) {
                console.log('Loading categories:', savedData.categories);
                // Clear existing selects (if any, typically for create page's initial empty select)
                if (!currentModuleId && categoriesContainer.querySelector('.module-category-item') && categoriesContainer.querySelectorAll('.module-category-item').length === 1 && categoriesContainer.querySelector('select').value === '') {
                    categoriesContainer.innerHTML = '';
                } else if (currentModuleId) {
                    // For edit page, we need to clear and re-add to overwrite Blade's initial render
                    categoriesContainer.innerHTML = '';
                }

                const categoryOptionsHtml = categoriesContainer.dataset.options || ''; // Get options for new selects

                savedData.categories.forEach((categoryId, index) => {
                    const newCategoryItem = document.createElement('div');
                    newCategoryItem.className = 'flex items-center mb-2 module-category-item';
                    // Construct innerHTML to include select and appropriate button
                    newCategoryItem.innerHTML = `
                        <select name="module_category_ids[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="">Pilih Kategori Modul</option>
                            ${categoryOptionsHtml ? categoryOptionsHtml : categoriesContainer.dataset.options}
                        </select>
                        ${index === 0 ? '<button type="button" class="ml-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded add-category-btn">+</button>' : '<button type="button" class="ml-2 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded remove-category-btn">-</button>'}
                    `;
                    categoriesContainer.appendChild(newCategoryItem);

                    const selectElement = newCategoryItem.querySelector('select[name="module_category_ids[]"]');
                    if (selectElement) {
                        selectElement.value = categoryId;
                    }
                });
                updateRemoveButtons(categoriesContainer); // Re-run to ensure button visibility is correct
            }
        }
    }

    // Only apply localStorage logic if we are on module create/edit forms
    if (moduleForm) {
        console.log('Module form detected. Applying localStorage logic.');
        // Load data on page load
        loadModuleFormData();

        // Save data on input change
        moduleNameInput.addEventListener('input', saveModuleFormData);

        // Delegated event listeners for category changes and add/remove buttons
        const categoriesContainers = [moduleCategoriesContainer, moduleCategoriesContainerEdit].filter(Boolean);
        categoriesContainers.forEach(container => {
            if (container) {
                container.addEventListener('change', (event) => {
                    if (event.target.matches('select[name="module_category_ids[]"]')) {
                        console.log('Category select change detected.');
                        saveModuleFormData();
                    }
                });
                container.addEventListener('click', (event) => {
                    if (event.target.matches('.add-category-btn') || event.target.matches('.remove-category-btn')) {
                        console.log('Add/Remove category button clicked.');
                        setTimeout(saveModuleFormData, 50); // Small delay for DOM update
                    }
                });
                // Also observe mutations for dynamic category additions/removals directly
                const observer = new MutationObserver(saveModuleFormData);
                observer.observe(container, { childList: true, subtree: true });
            }
        });

        // Clear unsaved data on form submission (successful save)
        moduleForm.addEventListener('submit', () => {
            console.log('Form submission detected. Clearing localStorage for unsavedModuleData.');
            localStorage.removeItem(unsavedDataKey);
            localStorage.removeItem('tiptapEditorContent');
            localStorage.removeItem('lastActiveModulePage');
        });

        // Handle initial rendering of categories for the edit page if there's no saved data
        // This prevents the page from clearing pre-filled categories from Blade on first load
        if (currentModuleId && !localStorage.getItem(unsavedDataKey) && moduleCategoriesContainerEdit) {
            // If no unsaved data, but on edit page, ensure dynamic category JS is set up
            // and updateRemoveButtons is called to fix button visibility.
            updateRemoveButtons(moduleCategoriesContainerEdit);
        }

    }

    // Tiptap Editor Initialization
    const editorRoot = document.getElementById('tiptap-editor');
    const hiddenInput = document.getElementById('content-hidden');

    if (editorRoot && hiddenInput) {
        import('./components/TiptapEditor').then(({ default: TiptapEditor }) => {
            // Content for TiptapEditor is already handled within TiptapEditor.jsx
            // which loads from 'tiptapEditorContent' localStorage key.
            // We just need to ensure the onUpdate callback correctly updates the hidden input.

            ReactDOM.createRoot(editorRoot).render(
                <React.StrictMode>
                    <TiptapEditor
                        content={hiddenInput.value} // Initial content from server, TiptapEditor itself loads from local storage
                        onUpdate={(html) => {
                            hiddenInput.value = html;
                            // No need to save to localStorage here, TiptapEditor component handles it.
                        }}
                    />
                </React.StrictMode>
            );
        }).catch(error => {
            console.error("Failed to load TiptapEditor component:", error);
        });
    }
});
