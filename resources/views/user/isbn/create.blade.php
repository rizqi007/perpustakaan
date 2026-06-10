@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('isbn.index') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-800">Formulir Pengajuan ISBN</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-8">
            <form action="{{ route('isbn.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="col-span-1 md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="author" id="author" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('author') border-red-500 @enderror" value="{{ old('author') }}" required>
                        @error('author')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" name="publisher" id="publisher" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('publisher') border-red-500 @enderror" value="{{ old('publisher') }}" required>
                        @error('publisher')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Terbit <span class="text-red-500">*</span></label>
                        <input type="number" name="publication_year" id="publication_year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('publication_year') border-red-500 @enderror" value="{{ old('publication_year', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                        @error('publication_year')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-1">Bahasa <span class="text-red-500">*</span></label>
                        <select name="language" id="language" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('language') border-red-500 @enderror" required>
                            <option value="Indonesian" {{ old('language') == 'Indonesian' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="Arabic" {{ old('language') == 'Arabic' ? 'selected' : '' }}>Bahasa Arab</option>
                            <option value="Other" {{ old('language') == 'Other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('language')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="pages" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Halaman</label>
                        <input type="number" name="pages" id="pages" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('pages') border-red-500 @enderror" value="{{ old('pages') }}" min="1">
                        @error('pages')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN (Jika perbaikan)</label>
                        <input type="text" name="isbn" id="isbn" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('isbn') border-red-500 @enderror" value="{{ old('isbn') }}" placeholder="Kosongkan jika baru">
                        @error('isbn')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-1 md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Sinopsis</label>
                        <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="col-span-1 md:col-span-2">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Upload File (PDF) <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 mb-2">Upload naskah buku atau dokumen pendukung dalam format PDF. Maksimal 10MB.</p>
                        <input type="file" name="file" id="file" accept=".pdf" class="w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-green-50 file:text-green-700
                            hover:file:bg-green-100
                            @error('file') border-red-500 @enderror" required>
                        @error('file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="button" onclick="window.history.back()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded mr-3 transition duration-300">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow transition duration-300">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
