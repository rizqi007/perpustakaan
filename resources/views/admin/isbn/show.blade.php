@extends('layouts.app')

@section('content')
@include('partials.admin-nav')

<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('admin.isbn.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Review Pengajuan ISBN</h1>
        </div>
        <div>
            {!! $submission->status_badge !!}
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Submission Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Buku</h2>
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
                            <dt class="text-sm font-medium text-gray-500">ISBN Existing</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $submission->isbn ?? '-' }}</dd>
                        </div>
                        
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $submission->description ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 bg-gray-50 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">File Dokumen</h2>
                    <a href="{{ route('admin.isbn.download', $submission->id) }}" class="text-sm bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200">
                        <i class="fas fa-download mr-1"></i> Download
                    </a>
                </div>
                <div class="p-6">
                    <div class="flex items-center p-4 bg-gray-50 rounded border border-gray-200 mb-4">
                        <i class="fas fa-file-pdf text-red-500 text-3xl mr-4"></i>
                        <div>
                            <p class="font-medium text-gray-900">{{ $submission->file_original_name }}</p>
                            <p class="text-xs text-gray-500">PDF Document</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Actions & Info -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Review Actions</h2>
                </div>
                <div class="p-6 space-y-4">
                    @if($submission->status == 'pending')
                    <div class="grid grid-cols-2 gap-4">
                        <form action="{{ route('admin.isbn.approve', $submission->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan ini?');">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition duration-300">
                                <i class="fas fa-check mr-2"></i> Setujui
                            </button>
                        </form>
                        
                        <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition duration-300">
                            <i class="fas fa-times mr-2"></i> Tolak
                        </button>
                    </div>
                    @else
                        <div class="text-center p-4 bg-gray-50 rounded">
                            <p class="text-gray-500">Pengajuan ini sudah diproses.</p>
                            <p class="font-medium mt-1">Status: <span class="uppercase">{{ $submission->status }}</span></p>
                            @if($submission->status == 'rejected')
                                <p class="text-red-500 text-sm mt-2 font-medium">Alasan: {{ $submission->rejection_reason }}</p>
                            @endif
                            <div class="mt-2 text-xs text-gray-400">
                                Reviewed by {{ $submission->reviewer ? $submission->reviewer->name : 'Unknown' }} on {{ $submission->reviewed_at ? $submission->reviewed_at->format('d M Y H:i') : '-' }}
                            </div>
                        </div>
                    @endif
                    
                    <hr class="border-gray-200 my-4">
                    
                    <form action="{{ route('admin.isbn.updateNotes', $submission->id) }}" method="POST">
                        @csrf
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Internal Admin</label>
                        <textarea name="admin_notes" id="admin_notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 text-sm mb-2">{{ $submission->admin_notes }}</textarea>
                        <div class="text-right">
                            <button type="submit" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-1 px-3 rounded">
                                Simpan Catatan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Informasi Pengaju</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 mr-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $submission->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $submission->user->role }}</p>
                        </div>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Email:</span>
                            <span class="text-gray-900">{{ $submission->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Terdaftar:</span>
                            <span class="text-gray-900">{{ $submission->user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                        <a href="{{ route('admin.isbn.index', ['user_id' => $submission->user_id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            Lihat semua pengajuan user ini
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('rejectModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.isbn.reject', $submission->id) }}" method="POST">
                @csrf
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Pengajuan ISBN</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-4">
                                    Silakan berikan alasan penolakan untuk pengajuan ini. Informasi ini akan dilihat oleh user.
                                </p>
                                <textarea name="rejection_reason" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200" placeholder="Contoh: Dokumen tidak lengkap, format salah, dll." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tolak Pengajuan
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('rejectModal').classList.add('hidden')">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
