<div class="bg-white shadow-sm border-b border-gray-200 mb-6">
    <div class="container mx-auto px-4">
        <nav class="flex space-x-8 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.dashboard') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.isbn.index') }}" class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.isbn.*') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-book mr-2"></i> Pengajuan ISBN
            </a>
            
            @if(auth()->user()->isSuperadmin())
            <a href="{{ route('admin.users.index') }}" class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.users.*') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-users mr-2"></i> Manajemen User
            </a>
            
            <a href="{{ route('admin.settings.edit') }}" class="py-4 px-1 border-b-2 font-medium text-sm whitespace-nowrap {{ request()->routeIs('admin.settings.*') ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                <i class="fas fa-cog mr-2"></i> Pengaturan Website
            </a>
            @endif
        </nav>
    </div>
</div>
