@extends('layouts.app')

@section('content')
@include('partials.admin-nav')

<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Website</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="site_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Website</label>
                <input type="text" name="site_name" id="site_name" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 @error('site_name') border-red-500 @enderror" value="{{ old('site_name', $settings->site_name) }}" required>
                @error('site_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Upload Logo</label>
                    @if($settings->logo)
                        <div class="mb-2">
                            <img src="{{ Storage::url('settings/' . $settings->logo) }}" alt="Current Logo" class="h-12 w-auto border p-1 rounded">
                        </div>
                    @endif
                    <input type="file" name="logo" id="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Format: PNG, JPG, SVG. Max: 2MB.</p>
                    @error('logo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="favicon" class="block text-sm font-medium text-gray-700 mb-1">Upload Favicon</label>
                    @if($settings->favicon)
                        <div class="mb-2">
                            <img src="{{ Storage::url('settings/' . $settings->favicon) }}" alt="Current Favicon" class="h-8 w-8 border p-1 rounded">
                        </div>
                    @endif
                    <input type="file" name="favicon" id="favicon" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Format: ICO, PNG. Max: 1MB.</p>
                    @error('favicon')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <hr class="my-6 border-gray-200">
            
            <div class="mb-4">
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="maintenance_mode" name="maintenance_mode" type="checkbox" value="1" {{ old('maintenance_mode', $settings->maintenance_mode) ? 'checked' : '' }} class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="maintenance_mode" class="font-medium text-gray-700">Aktifkan Maintenance Mode</label>
                        <p class="text-gray-500">Jika diaktifkan, hanya admin dan superadmin yang dapat mengakses website.</p>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <label for="maintenance_message" class="block text-sm font-medium text-gray-700 mb-1">Pesan Maintenance</label>
                <textarea name="maintenance_message" id="maintenance_message" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" placeholder="Pesan yang akan ditampilkan saat maintenance...">{{ old('maintenance_message', $settings->maintenance_message) }}</textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow transition duration-300">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
