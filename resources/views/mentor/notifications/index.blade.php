@extends('mentor.layout')

@section('title', 'Notifikasi Anda')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-1">Notifikasi</h2>
            <p class="text-sm text-gray-500">Kelola semua notifikasi Anda di satu tempat</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-bell text-blue-600"></i>
                    <h3 class="font-semibold text-gray-700">Semua Notifikasi</h3>
                    @if ($unreadNotificationsCount > 0)
                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">{{ $unreadNotificationsCount }} belum dibaca</span>
                    @endif
                </div>
                @if ($notifications->count() > 0)
                    <form action="{{ route('mentor.notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-check-double mr-1.5 text-blue-500"></i>
                            Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>

            @if ($notifications->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                    <div class="rounded-full bg-blue-50 p-3 mb-4">
                        <i class="fas fa-bell text-blue-500 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada notifikasi</h3>
                    <p class="text-gray-500 text-sm max-w-sm">Anda belum memiliki notifikasi. Notifikasi baru akan muncul di sini.</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach ($notifications as $notification)
                        <div class="p-5 hover:bg-gray-50 transition-colors {{ !$notification->read_at ? 'bg-blue-50' : '' }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                        <i class="fas {{ $notification->type === 'App\\Notifications\\ReviewReplied' ? 'fa-comment-dots' : 'fa-bell' }}"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            @if ($notification->type === 'App\\Notifications\\ReviewReplied')
                                                <p class="font-medium text-gray-900">Balasan Baru</p>
                                                <p class="text-gray-700 text-sm mt-1">Ulasan Anda pada modul <a href="{{ $notification->data['link'] }}" class="text-blue-600 hover:underline font-medium">{{ $notification->data['module_name'] }}</a> telah dibalas oleh {{ $notification->data['replier_name'] ?? 'Sistem' }}.</p>
                                            @else
                                                <p class="font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</p>
                                                <p class="text-gray-700 text-sm mt-1">{{ $notification->data['message'] ?? 'Notifikasi baru.' }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ \Carbon\Carbon::parse($notification->created_at)->locale('id')->translatedFormat('d F Y, H:i') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if (!$notification->read_at)
                                                <form action="{{ route('mentor.notifications.markAsRead', $notification->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Tandai Dibaca
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('mentor.notifications.markAsUnread', $notification->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                                        <i class="fas fa-eye mr-1"></i>
                                                        Tandai Belum Dibaca
                                                    </button>
                                                </form>
                                                <form action="{{ route('mentor.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                        <i class="fas fa-trash-alt mr-1"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if ($notifications->count() > 0)
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
