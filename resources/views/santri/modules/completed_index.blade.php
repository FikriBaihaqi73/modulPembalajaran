@extends('santri.layouts.app')

@section('title', 'Modul Selesai Dibaca')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Daftar Modul yang Sudah Selesai Dibaca</h2>
            <p class="text-gray-600 text-center">Lihat kembali modul-modul yang telah Anda selesaikan.</p>
        </div>

        {{-- Diagram Statistik Modul --}}
        <div class="bg-white rounded-lg shadow-sm p-4 mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Statistik Modul Anda</h3>
            <div class="flex flex-col md:flex-row items-center justify-around gap-4">
                <div class="md:w-1/2 flex justify-center">
                    <pre class="mermaid">
                        pie title Statistik Modul Anda
                            "Selesai" : {{ $completedModulesCount }}
                            "Belum Selesai" : {{ $uncompletedModulesCount }}
                    </pre>
                </div>
                <div class="md:w-1/2 text-gray-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Total Modul: <span class="font-semibold">{{ $totalModules }}</span></li>
                        <li>Modul Selesai: <span class="font-semibold text-green-600">{{ $completedModulesCount }}</span></li>
                        <li>Modul Belum Selesai: <span class="font-semibold text-red-600">{{ $uncompletedModulesCount }}</span></li>
                    </ul>
                    <p class="mt-4 text-sm text-gray-600">Diagram di atas menunjukkan perbandingan modul yang telah Anda selesaikan dengan yang belum selesai dari total modul yang tersedia untuk jurusan Anda.</p>
                </div>
            </div>
        </div>

        {{-- Search and Filter Bar --}}
        <div class="bg-white rounded-lg shadow-sm p-4 mb-8">
            <form action="{{ route('santri.modules.completed') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="flex-grow">
                    <label for="search" class="sr-only">Cari Modul</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" placeholder="Cari judul modul..." value="{{ request('search') }}"
                            class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm">
                    </div>
                </div>

                <div class="md:w-56">
                    <label for="module_category_id" class="sr-only">Kategori</label>
                    <select id="module_category_id" name="module_category_id"
                        class="focus:ring-blue-500 focus:border-blue-500 block w-full py-2 px-3 border border-gray-300 rounded-md text-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($moduleCategories as $category)
                            <option value="{{ $category->id }}" {{ request('module_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    @if(request('search') || request('module_category_id'))
                        <a href="{{ route('santri.modules.completed') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Module Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-8">
            @forelse($modules as $module)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
                    <a href="{{ route('santri.modules.show', $module->id) }}" class="flex-grow flex flex-col">
                        {{-- Thumbnail with overlay for better visibility --}}
                        <div class="w-full aspect-square relative bg-gray-100">
                            <img id="module-img-{{ $module->id }}"
                                 src="{{ $module->thumbnail }}"
                                 alt="{{ $module->name }}"
                                 class="w-full h-full object-contain {{ $module->thumbnail ? '' : 'hidden' }}"
                                 onerror="this.classList.add('hidden'); document.getElementById('module-no-image-{{ $module->id }}').classList.remove('hidden');">

                            {{-- No Image SVG Fallback --}}
                            <div id="module-no-image-{{ $module->id }}"
                                 class="absolute inset-0 flex items-center justify-center text-gray-400 {{ $module->thumbnail ? 'hidden' : '' }}">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="p-4 flex-grow flex flex-col">
                            {{-- Title & Date --}}
                            <h3 class="text-lg font-semibold text-gray-900 line-clamp-2 mb-1">{{ $module->name }}</h3>
                            <p class="text-xs text-gray-500 mb-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ optional($module->created_at)->format('d M Y') }}
                            </p>

                            {{-- Completion Status --}}
                            <div class="mb-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="-ml-0.5 mr-1.5 h-3 w-3 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"></circle>
                                    </svg>
                                    Selesai
                                </span>
                            </div>

                            {{-- Categories --}}
                            <div class="flex flex-wrap gap-1 mb-2">
                                @forelse($module->moduleCategory as $category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-xs">Tidak ada kategori</span>
                                @endforelse
                            </div>

                            {{-- Content Preview --}}
                            <p class="text-sm text-gray-600 line-clamp-2 mt-auto">
                                {!! Str::limit(strip_tags($module->content), 60) !!}
                            </p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full py-12">
                    <div class="flex flex-col items-center justify-center text-center px-6">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        @if(request('search') || request('module_category_id'))
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada hasil yang ditemukan</h3>
                            <p class="mt-1 text-sm text-gray-500">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                            <a href="{{ route('santri.modules.completed') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Reset Filter
                            </a>
                        @else
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Anda belum menyelesaikan modul apapun.</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulailah belajar dari daftar modul yang tersedia!</p>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination with better styling --}}
        <div class="flex justify-center my-8">
            {{ $modules->links() }}
        </div>
    </div>
@endsection

<script type="module">
    import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
</script>
