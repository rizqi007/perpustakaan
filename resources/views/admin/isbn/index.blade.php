@extends('layouts.app')

@section('content')
@include('partials.admin-nav')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Pengajuan ISBN</h1>
        
        <form action="{{ route('admin.isbn.index') }}" method="GET" class="flex space-x-2">
            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded transition duration-300">
                Filter
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <!-- Stats Summary for this page -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow text-center">
            <h3 class="text-sm text-gray-500 uppercase">Total</h3>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center border-b-2 border-yellow-400">
            <h3 class="text-sm text-gray-500 uppercase">Pending</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center border-b-2 border-green-400">
            <h3 class="text-sm text-gray-500 uppercase">Disetujui</h3>
            <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center border-b-2 border-red-400">
            <h3 class="text-sm text-gray-500 uppercase">Ditolak</h3>
            <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Buku</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengaju</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($submissions as $submission)
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
                            <div class="text-sm text-gray-500">{{ $submission->created_at->format('d M Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {!! $submission->status_badge !!}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.isbn.show', $submission->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">Review</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            Tidak ada data pengajuan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($submissions->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
