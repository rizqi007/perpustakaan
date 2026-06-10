@extends('layouts.app')

@section('content')
@include('partials.admin-nav')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold">Total Pengajuan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_submissions'] }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-book text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold">Menunggu Review</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_submissions'] }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
            </div>
            <a href="{{ route('admin.isbn.index', ['status' => 'pending']) }}" class="text-sm text-blue-600 hover:underline mt-2 inline-block">Lihat detail</a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold">Disetujui</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['approved_submissions'] }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 uppercase font-semibold">Ditolak</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['rejected_submissions'] }}</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-times text-red-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Submissions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800">Pengajuan Terbaru</h2>
            <a href="{{ route('admin.isbn.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengaju</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentSubmissions as $submission)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($submission->title, 30) }}</div>
                            <div class="text-sm text-gray-500">{{ $submission->isbn ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $submission->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $submission->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $submission->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {!! $submission->status_badge !!}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.isbn.show', $submission->id) }}" class="text-blue-600 hover:text-blue-900">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            Belum ada pengajuan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
