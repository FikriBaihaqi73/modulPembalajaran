@extends('santri.layouts.app')

@section('title', 'Detail Modul')

@section('content')
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden mb-8">
        {{-- Back link - mobile friendly top navigation --}}
        <div class="bg-gray-50 py-3 px-4 sm:px-6 border-b flex items-center">
            <a href="{{ route('santri.modules.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Modul
            </a>
        </div>

        {{-- Thumbnail --}}
        @if ($module->thumbnail)
            <div class="w-full aspect-video overflow-hidden bg-gray-100">
                <img src="{{ $module->thumbnail }}" alt="Thumbnail Modul" class="w-full h-full object-contain">
            </div>
        @endif

        <div class="px-4 py-5 sm:px-6">
            {{-- Title with badge indicator --}}
            <div class="flex flex-wrap items-start justify-between">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-1">{{ $module->name }}</h1>
            </div>

            {{-- Metadata row --}}
            <div class="mt-2 flex flex-wrap items-center text-sm text-gray-500 space-x-4">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($module->created_at)->locale('id')->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($module->created_at)->format('H:i') }}</span>
                </div>
            </div>

            {{-- Categories --}}
            <div class="mt-4 flex flex-wrap gap-2">
                @forelse($module->moduleCategory as $category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $category->name }}
                    </span>
                @empty
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Tidak ada kategori
                    </span>
                @endforelse
                @if($module->major)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        {{ $module->major->name }}
                    </span>
                @endif
            </div>

            {{-- Download PDF Button --}}
            <div class="mt-4 flex flex-wrap items-center gap-4">
                <a href="{{ route('santri.modules.download.pdf', $module->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m-8 7H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v8a2 2 0 01-2 2h-8m-4 0v-2a4 4 0 014-4h.875M16 18V9a2 2 0 00-2-2h-4a2 2 0 00-2 2v9m-3 3h10a2 2 0 002-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v13a2 2 0 002 2zM7 9h6"></path>
                    </svg>
                    Unduh Modul (PDF)
                </a>

                @auth
                    <form action="{{ route('santri.modules.toggleCompletion', $module->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white {{ $module->is_completed_by_current_user ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            @if($module->is_completed_by_current_user)
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2A9 9 0 111 12a9 9 0 0118 0z"></path>
                                </svg>
                                Tandai Belum Selesai
                            @else
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tandai Selesai
                            @endif
                        </button>
                    </form>
                @endauth
            </div>

        </div>

        {{-- Content Divider --}}
        <div class="border-t border-gray-200"></div>

        {{-- Module Content --}}
        <div class="px-4 py-5 sm:px-6">
            <div class="prose prose-sm sm:prose max-w-none text-gray-800 leading-relaxed">
                {!! $module->content !!}
            </div>
        </div>

        {{-- Reviews Section --}}
        <div class="border-t border-gray-200"></div>
        <div class="px-4 py-5 sm:px-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Ulasan Modul</h2>

            {{-- Average Rating Display --}}
            @if($module->reviews->count() > 0)
                <div class="flex items-center mb-4">
                    <div class="flex items-center text-yellow-500 mr-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= round($module->average_rating))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="text-gray-700 text-lg font-semibold">{{ number_format($module->average_rating, 1) }} dari 5 ({{ $module->reviews->count() }} ulasan)</span>
                </div>
            @else
                <p class="text-gray-600 mb-4">Belum ada ulasan untuk modul ini.</p>
            @endif

            {{-- Review Form --}}
            @auth
                @if (!$userReview)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">Berikan Ulasan Anda</h3>
                        <form action="{{ route('santri.modules.storeReview', $module->id) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Penilaian</label>
                                <select name="rating" id="rating" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="0" selected disabled>Pilih Rating</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('rating', $userReview->rating ?? 0) == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                                    @endfor
                                </select>
                                @error('rating')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar Anda (Opsional)</label>
                                <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Bagikan pemikiran Anda tentang modul ini..."></textarea>
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>
                @else
                    <div x-data="{ showEditForm: {{ $errors->any() ? 'true' : 'false' }} }">
                        <div x-show="!showEditForm" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm mb-6" role="alert">
                            <p class="font-bold mb-1">Anda telah mengulas modul ini.</p>
                            <p>Penilaian Anda: <span class="font-semibold">{{ $userReview->rating }} Bintang</span></p>
                            @if ($userReview->comment)
                                <p>Komentar Anda: <em>"{{ $userReview->comment }}"</em></p>
                            @endif
                            <button @click="showEditForm = true" class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Edit Ulasan
                            </button>
                        </div>

                        {{-- Edit Review Form --}}
                        <div x-show="showEditForm" class="bg-gray-50 p-4 rounded-lg shadow-sm mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">Edit Ulasan Anda</h3>
                            <form action="{{ route('santri.modules.updateReview', ['module' => $module->id, 'review' => $userReview->id]) }}" method="POST">
                                @csrf
                                @method('PUT') {{-- Use PUT method for update --}}
                                <div class="mb-4">
                                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Penilaian</label>
                                    <select name="rating" id="rating" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="0" disabled>Pilih Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('rating', $userReview->rating ?? '') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                                        @endfor
                                    </select>
                                    @error('rating')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar Anda (Opsional)</label>
                                    <textarea id="comment" name="comment" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Bagikan pemikiran Anda tentang modul ini...">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                                    @error('comment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center justify-end gap-3 mt-4">
                                    <button type="button" @click="showEditForm = false" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Batalkan
                                    </button>
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Perbarui Ulasan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm mb-6" role="alert">
                    <p class="font-medium">Silakan <a href="{{ route('login') }}" class="font-semibold underline">login</a> untuk memberikan ulasan pada modul ini.</p>
                </div>
            @endauth

            {{-- List of Reviews --}}
            <div class="space-y-6">
                @forelse ($module->reviews as $review)
                    @if (Auth::guest() || (Auth::check() && $review->user_id !== Auth::id()))
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <div class="flex items-center mb-2">
                                <p class="font-semibold text-gray-800 mr-2">{{ $review->user->name ?? 'Pengguna Anonim' }}</p>
                                <div class="flex items-center text-yellow-500 text-sm">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @if ($review->comment)
                                <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($review->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}</p>
                        </div>
                    @endif
                @empty
                    @if(Auth::guest() || (Auth::check() && !$userReview))
                        <p class="text-gray-600">Jadilah yang pertama mengulas modul ini!</p>
                    @endif
                @endforelse
            </div>
        </div>
    </div>
@endsection
