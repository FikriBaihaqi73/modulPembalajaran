@extends('mentor.layout')

@section('title', 'Detail Kemajuan Modul')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Kemajuan Modul: {{ $module->name }}</h2>
            <a href="{{ route('mentor.module-progress.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Module Info Card --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Informasi Modul</h3>
                <p class="text-gray-700 mb-2"><strong>Nama Modul:</strong> {{ $module->name }}</p>
                <p class="text-gray-700 mb-2"><strong>Dibuat Oleh:</strong> {{ $module->user->name ?? 'Mentor Tidak Dikenal' }}</p>
                <p class="text-gray-700 mb-2"><strong>Jurusan:</strong> {{ $module->major->name ?? 'Tidak Ada Jurusan' }}</p>
                <p class="text-gray-700"><strong>Visibilitas:</strong> {{ $module->is_visible ? 'Terlihat' : 'Tersembunyi' }}</p>
            </div>

            {{-- Progress Summary Chart --}}
            <div class="bg-white rounded-lg shadow-sm p-6 flex flex-col items-center justify-center">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Kemajuan</h3>
                <div class="relative w-full max-w-xs">
                    <canvas id="moduleProgressChart"></canvas>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-gray-700">Total Santri Melacak: <span class="font-semibold">{{ $completionData['total_tracking'] }}</span></p>
                </div>
            </div>
        </div>

        {{-- Student Progress Table --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Kemajuan Santri</h3>

            @if ($module->progress->isEmpty())
                <p class="text-gray-600">Belum ada santri yang melacak modul ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Santri</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($module->progress as $progress)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $progress->user->name ?? 'Pengguna Tidak Dikenal' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $progress->is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $progress->is_completed ? 'Selesai' : 'Belum Selesai' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($progress->updated_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Reviews Section --}}
        <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Ulasan Modul</h3>

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

                <div class="space-y-6">
                    @foreach ($module->reviews as $review)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
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
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Belum ada ulasan untuk modul ini.</p>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('moduleProgressChart').getContext('2d');
            const completionData = @json($completionData);

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Selesai', 'Belum Selesai'],
                    datasets: [{
                        data: [completionData.completed, completionData.not_completed],
                        backgroundColor: ['#10B981', '#F59E0B'], // Green and Yellow
                        hoverBackgroundColor: ['#059669', '#D97706']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += context.parsed + ' Santri';
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });

            // Star Rating Logic
            const starRatingContainer = document.getElementById('star-rating-container');
            const ratingInput = document.getElementById('rating');
            const stars = starRatingContainer.querySelectorAll('i');

            let currentRating = parseInt(ratingInput.value) || 0;

            function updateStars(rating) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('far');
                        star.classList.add('fas', 'text-yellow-500');
                    } else {
                        star.classList.remove('fas', 'text-yellow-500');
                        star.classList.add('far');
                    }
                });
            }

            // Initial star display
            updateStars(currentRating);

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const rating = parseInt(star.dataset.rating);
                    currentRating = rating;
                    ratingInput.value = rating;
                    updateStars(rating);
                });

                star.addEventListener('mouseover', () => {
                    const rating = parseInt(star.dataset.rating);
                    updateStars(rating);
                });

                star.addEventListener('mouseout', () => {
                    updateStars(currentRating);
                });
            });
        });
    </script>
@endsection
