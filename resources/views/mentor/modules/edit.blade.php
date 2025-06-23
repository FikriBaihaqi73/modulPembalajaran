@extends('mentor.layout')

@section('title', 'Edit Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Edit Modul</h2>

    <div class="mt-4 bg-white p-6 rounded shadow">
        <form action="{{ route('mentor.modules.update', $module->id) }}" method="POST" enctype="multipart/form-data" id="moduleForm">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Modul:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name', $module->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori Modul:</label>
                <div id="module-categories-container-edit" data-options='<select name="module_category_ids[]">@foreach($moduleCategories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select>'>
                    @php
                        // Get old selected categories in case of validation error, otherwise get existing module categories
                        $selectedCategories = old('module_category_ids', $module->moduleCategory->pluck('id')->toArray());
                        // Ensure there's at least one category selected if the module has none, for the initial select box
                        if (empty($selectedCategories) && $moduleCategories->isNotEmpty()) {
                            $selectedCategories = ['']; // Add an empty option for the default select
                        } elseif (empty($selectedCategories) && $moduleCategories->isEmpty()) {
                            $selectedCategories = []; // No categories available at all, leave empty
                        }
                    @endphp

                    @forelse($selectedCategories as $index => $selectedCategoryId)
                        <div class="flex items-center mb-2 module-category-item">
                            <select name="module_category_ids[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('module_category_ids.' . $index) border-red-500 @enderror" required>
                                <option value="">Pilih Kategori Modul</option>
                                @foreach($moduleCategories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if($loop->first) {{-- Only the first one gets the add button --}}
                                <button type="button" class="ml-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded add-category-btn">
                                    +
                                </button>
                            @else {{-- Subsequent ones get a remove button --}}
                                <button type="button" class="ml-2 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded remove-category-btn">
                                    -
                                </button>
                            @endif
                        </div>
                    @empty
                        {{-- Fallback if no categories are found or old categories are empty, and moduleCategories is not empty --}}
                        @if($moduleCategories->isNotEmpty())
                            <div class="flex items-center mb-2 module-category-item">
                                <select name="module_category_ids[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('module_category_ids.0') border-red-500 @enderror" required>
                                    <option value="">Pilih Kategori Modul</option>
                                    @foreach($moduleCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('module_category_ids.0') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="ml-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded add-category-btn">
                                    +
                                </button>
                            </div>
                        @else
                            <p class="text-gray-600">Tidak ada kategori modul yang tersedia.</p>
                        @endif
                    @endforelse
                </div>
                @error('module_category_ids')
                    <p class="text-red-500 text-xs italic">Anda harus memilih setidaknya satu kategori modul.</p>
                @enderror
                @error('module_category_ids.*')
                    <p class="text-red-500 text-xs italic">Isian kategori modul tidak valid.</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Konten Modul:</label>
                <div id="tiptap-editor"></div>
                <input type="hidden" name="content" id="content-hidden" value="{{ old('content', $module->content) }}">
                @error('content')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="thumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail Modul:</label>
                @if ($module->thumbnail)
                    <img src="{{ $module->thumbnail }}" alt="Thumbnail Modul" class="w-32 h-32 object-cover mb-2">
                @endif
                <input type="file" name="thumbnail" id="thumbnail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('thumbnail') border-red-500 @enderror">
                @error('thumbnail')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Modul
                </button>
                <a href="{{ route('mentor.modules.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
{{-- Menghapus script inisialisasi TipTap yang dipindahkan ke mentor.js --}}
{{--
<script type="module">
    import React from 'react';
    import ReactDOM from 'react-dom/client';
    import TiptapEditor from '../../js/components/TiptapEditor';

    const editorRoot = document.getElementById('tiptap-editor');
    const hiddenInput = document.getElementById('content-hidden');

    if (editorRoot) {
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
    }
</script>
--}}
@endsection
