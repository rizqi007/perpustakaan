<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<aside class="w-full md:w-64 bg-[#1e293b] text-white flex flex-col h-screen sticky top-0">
    <!-- Logo -->
    <div class="p-6 flex items-center gap-3 border-b border-gray-700/50">
        <div class="bg-emerald-500/10 p-2 rounded-lg">
             @if(isset($site_logo) && $site_logo)
                <img src="{{ asset('storage/' . $site_logo) }}" alt="Logo" class="block h-8 w-auto fill-current text-emerald-500 object-contain">
             @else
                <x-application-logo class="block h-8 w-auto fill-current text-emerald-500" />
             @endif
        </div>
        <div>
            <span class="block font-bold text-lg leading-tight tracking-wide uppercase">{{ $site_name }}</span>
            <span class="text-[10px] font-medium text-slate-400 tracking-wider">KEMENTERIAN AGAMA RI</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1 [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-slate-700 hover:[&::-webkit-scrollbar-thumb]:bg-slate-600">
        
        <!-- MENU Section -->
        <div class="px-3 mb-2 mt-2">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Menu</p>
        </div>

        @if(!auth()->user()->hasAdminAccess())
        <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            {{ __('Dashboard') }}
        </a>
        @endif

        @if(!auth()->user()->hasAdminAccess())

        <a href="{{ route('isbn.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('isbn.index') || request()->routeIs('isbn.edit') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('isbn.index') || request()->routeIs('isbn.edit') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            {{ __('Riwayat ISBN') }}
        </a>
        @endif

        @if(auth()->user()->hasAdminAccess())
            <!-- ADMIN Section -->
            <!-- <div class="px-3 mb-2 mt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Admin</p>
            </div> -->

            <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                 <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                </svg>
                {{ __('Dashboard Admin') }}
            </a>

            <!-- KONTEN Section -->
            <div class="px-3 mb-2 mt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Konten</p>
            </div>
            
            <a href="{{ route('admin.banners.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.banners.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.banners.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                {{ __('Banner') }}
            </a>
            
            <a href="{{ route('admin.berita.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.berita.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.berita.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                </svg>
                {{ __('Berita & Artikel') }}
            </a>

            <a href="/admin/forms" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->is('admin/forms*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5 {{ request()->is('admin/forms*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                {{ __('Formulir') }}
            </a>

            <a href="{{ route('admin.pages.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.pages.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.pages.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                {{ __('Profil & Sejarah') }}
            </a>
            
            <a href="{{ route('admin.layanan.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.layanan.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                 <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.layanan.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.26 2.26 0 0019 22.24A2.26 2.26 0 0022.24 19a2.26 2.26 0 00-1.24-1.75l-5.83-5.83m0-8.48a6 6 0 017.2 7.2m-8.48 4L4.82 2.91a2.26 2.26 0 00-1.23-.33A2.26 2.26 0 000 4.15A2.26 2.26 0 000 6.41a2.26 2.26 0 002.91 3.5l11.31 11.31M6.25 22.24A2.26 2.26 0 005 21l-3.3-3.3a2.26 2.26 0 00-.33-1.23L1.24 6.75A2.26 2.26 0 002.91 3.5a2.26 2.26 0 003.5 1.67L16.41 15.17a6 6 0 01-7.2-7.2l3.3-3.3a2.26 2.26 0 001.23-.33A2.26 2.26 0 0016.41 0a2.26 2.26 0 00-2.26 2.26 2.26 2.26 0 00-.33 1.23L5 16.25z" />
                </svg>
                {{ __('Layanan') }}
            </a>

            <!-- MANAJEMEN Section -->
            <div class="px-3 mb-2 mt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Manajemen</p>
            </div>

            <a href="{{ route('admin.isbn.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.isbn.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                 <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.isbn.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                </svg>
                {{ __('Pengajuan ISBN') }}
            </a>

            <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.users.*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
                {{ __('Pengguna') }}
            </a>

            <!-- SYSTEM Section -->
            <div class="px-3 mb-2 mt-6">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan</p>
            </div>

            <a href="{{ route('admin.settings') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.settings') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.settings') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l-.527-.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ __('Pengaturan Website') }}
            </a>

             <a href="{{ route('profile') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('profile') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                 <svg class="mr-3 h-5 w-5 {{ request()->routeIs('profile') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                {{ __('Edit Profile') }}
            </a>

            @if(auth()->user()->isSuperadmin())
                <a href="{{ route('admin.database-backup') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 w-full {{ request()->routeIs('admin.database-backup') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}" wire:navigate>
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.database-backup') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                    {{ __('Backup Database') }}
                </a>
            @endif
        @endif

           
    </nav>
    
    <!-- Profile & Logout Section -->
    <div class="p-4 border-t border-gray-700/50 bg-[#111827]">
        <div class="flex items-center gap-3 mb-4">
             <div class="h-10 w-10 min-w-[2.5rem] rounded-full bg-emerald-600 flex items-center justify-center text-white font-bold text-lg border-2 border-slate-600 shadow-sm">
                {{ substr(auth()->user()->name, 0, 1) }}
             </div>
             <div class="overflow-hidden">
                 <div class="font-bold text-sm text-white truncate" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                 <div class="text-xs text-slate-400 truncate">{{ auth()->user()->role ?? 'User' }}</div>
             </div>
        </div>
        


        <!-- Authentication -->
        <button wire:click="logout" class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors group">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:scale-110 transition-transform">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
            </svg>
            {{ __('Keluar') }}
        </button>
    </div>
</aside>
