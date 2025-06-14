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
        });
    </script>
@endsection
