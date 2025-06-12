@extends('mentor.layout')

@section('title', 'Tambah Modul')

@section('content')
    <h2 class="text-3xl font-semibold text-gray-800">Tambah Modul Baru</h2>

    <div class="mt-4 bg-white p-6 rounded shadow">
        <form action="{{ route('mentor.modules.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Modul:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="module_category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori Modul:</label>
                <select name="module_category_id" id="module_category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('module_category_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kategori Modul</option>
                    @foreach($moduleCategories as $category)
                        <option value="{{ $category->id }}" {{ old('module_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('module_category_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Konten Modul:</label>
                <div id="tiptap-editor"></div>
                <input type="hidden" name="content" id="content-hidden" value="{{ old('content') }}">
                @error('content')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Modul
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
