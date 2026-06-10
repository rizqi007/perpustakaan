@extends('layouts.app')

@section('content')
@include('partials.admin-nav')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
        
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
            <select name="role" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                <option value="">Semua Role</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="superadmin" {{ request('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
            </select>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded transition duration-300">
                Cari
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow text-center">
            <h3 class="text-sm text-gray-500 uppercase">Total User</h3>
            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center border-b-2 border-blue-400">
            <h3 class="text-sm text-gray-500 uppercase">User Biasa</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['users'] }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center border-b-2 border-purple-400">
            <h3 class="text-sm text-gray-500 uppercase">Admin</h3>
            <p class="text-2xl font-bold text-purple-600">{{ $stats['admins'] }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow text-center border-b-2 border-red-400">
            <h3 class="text-sm text-gray-500 uppercase">Superadmin</h3>
            <p class="text-2xl font-bold text-red-600">{{ $stats['superadmins'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bergabung</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role == 'superadmin' ? 'bg-red-100 text-red-800' : 
                                   ($user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="inline-block mr-2">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="text-xs rounded border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                                    </select>
                                </form>
                                
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs italic">Akun Anda</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                            Tidak ada pengguna ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
