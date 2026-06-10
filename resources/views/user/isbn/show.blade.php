@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('isbn.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan ISBN</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-1 md:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">Informasi Buku</h2>
                        {!! $submission->status_badge !!}
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Judul Buku</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $submission->title }}</dd>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Penulis</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $submission->author }}</dd>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Penerbit</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $submission->publisher }}</dd>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Tahun Terbit</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $submission->publication_year }}</dd>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Bahasa</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $submission->language }}</dd>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Jumlah Halaman</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $submission->pages ?? '-' }}</dd>
                            </div>
                            
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">ISBN</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $submission->isbn ?? '-' }}</dd>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $submission->description ?? '-' }}</dd>
                            </div>
                            
                            <div class="sm:col-span-2 pt-4 border-t mt-2">
                                <dt class="text-sm font-medium text-gray-500 mb-2">File Dokumen</dt>
                                <dd class="flex items-center text-sm">
                                    <i class="fas fa-file-pdf text-red-500 text-xl mr-3"></i>
                                    <span class="truncate mr-4 flex-1">{{ $submission->file_original_name }}</span>
                                    <span class="text-gray-400 text-xs">PDF Document</span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            
            <div class="col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-800">Status Pengajuan</h2>
                    </div>
                    <div class="p-6">
                        <div class="flow-root">
                            <ul role="list" class="-mb-8">
                                <li>
                                    <div class="relative pb-8">
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-paper-plane text-white text-xs"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">Pengajuan dibuat</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $submission->created_at }}">{{ $submission->created_at->format('d/m/Y') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                
                                @if($submission->reviewed_at)
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full {{ $submission->status == 'approved' ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas {{ $submission->status == 'approved' ? 'fa-check' : 'fa-times' }} text-white text-xs"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $submission->status == 'approved' ? 'Disetujui' : 'Ditolak' }}
                                                    </p>
                                                    @if($submission->reviewed_by)
                                                        <p class="text-xs text-gray-500">oleh {{ $submission->reviewer->name }}</p>
                                                    @endif
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $submission->reviewed_at }}">{{ $submission->reviewed_at->format('d/m/Y') }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                        
                        @if($submission->status === 'rejected' && $submission->rejection_reason)
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-md p-4">
                            <h4 class="text-sm font-medium text-red-800 mb-2">Alasan Penolakan:</h4>
                            <p class="text-sm text-red-700">{{ $submission->rejection_reason }}</p>
                        </div>
                        @endif
                        
                        @if($submission->admin_notes)
                        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <h4 class="text-sm font-medium text-yellow-800 mb-2">Catatan Admin:</h4>
                            <p class="text-sm text-yellow-700">{{ $submission->admin_notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
