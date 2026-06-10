<x-filament-panels::page>
    @php
        $mainMenus = \App\Models\NavigationMenu::whereNull('parent_id')->orderBy('order')->get();
        $activeParent = $selectedParentId ? \App\Models\NavigationMenu::find($selectedParentId) : null;
        $subMenus = $activeParent ? \App\Models\NavigationMenu::where('parent_id', $activeParent->id)->orderBy('order')->get() : collect();
    @endphp

    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-6 items-start">
            
            <!-- KOLOM KIRI: MENU UTAMA -->
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/10">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-900 dark:text-white">Menu Utama</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daftar navigasi tingkat induk</p>
                    </div>
                </div>
                
                <div class="p-6 space-y-3 min-h-[400px]">
                    @forelse($mainMenus as $menu)
                        <div draggable="true"
                             x-data="{ isOver: false }"
                             @dragstart="e => { e.dataTransfer.setData('text/plain', {{ $menu->id }}); }"
                             @dragover="e => { e.preventDefault(); isOver = true; }"
                             @dragleave="isOver = false"
                             @drop="e => { isOver = false; $wire.reorderMenus(e.dataTransfer.getData('text/plain'), {{ $menu->id }}); }"
                             :class="{ 'border-emerald-500 bg-emerald-50/10 ring-2 ring-emerald-500/10': isOver }"
                             class="relative flex items-center justify-between p-4 bg-white dark:bg-gray-800 border rounded-xl shadow-sm transition duration-150 hover:shadow-md cursor-pointer select-none {{ $selectedParentId == $menu->id ? 'border-emerald-500 bg-emerald-50/30 dark:bg-emerald-950/10 ring-2 ring-emerald-500/10' : 'border-gray-200 dark:border-gray-700' }}"
                             @click="if (event.target.tagName !== 'BUTTON' && event.target.tagName !== 'A' && !event.target.closest('button')) $wire.selectMainMenu({{ $menu->id }})">
                            
                            <div class="flex items-center gap-4">
                                <!-- Drag Handle -->
                                <div class="flex items-center gap-1 text-gray-400 cursor-grab active:cursor-grabbing p-1 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                                    </svg>
                                </div>
                                
                                <div class="flex flex-col">
                                    <span class="font-extrabold text-sm tracking-wide text-gray-900 dark:text-white uppercase">
                                        {{ $menu->label }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        @if($menu->children->count() > 0)
                                            <span class="italic text-emerald-600 dark:text-emerald-400 font-bold">Wadah Sub-menu (Dropdown)</span>
                                        @else
                                            {{ $menu->resolved_url }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <button wire:click.stop="mountAction('editMenu', { id: {{ $menu->id }} })" 
                                        class="p-2 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/30 dark:hover:bg-blue-900/40 transition rounded-lg"
                                        title="Ubah Menu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </button>
                                <button wire:click.stop="mountAction('deleteMenu', { id: {{ $menu->id }} })" 
                                        class="p-2 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 dark:bg-red-950/30 dark:hover:bg-red-900/40 transition rounded-lg"
                                        title="Hapus Menu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl">
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Belum ada menu utama. Klik tombol Tambah di atas.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- KOLOM KANAN: SUB-MENU -->
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50 dark:bg-gray-900/10">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-900 dark:text-white uppercase">
                            Sub-Menu: <span class="text-emerald-600 dark:text-emerald-400">{{ $activeParent ? $activeParent->label : 'Belum Dipilih' }}</span>
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Urutkan dan kelompokkan sub-menu dengan menarik handle</p>
                    </div>
                    @if($activeParent)
                        <button wire:click="mountAction('createMenu', { parent_id: {{ $activeParent->id }} })" 
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700 transition shadow-sm hover:shadow-emerald-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Sub-Menu
                        </button>
                    @endif
                </div>
                
                <div class="p-6 space-y-3 min-h-[400px] flex flex-col justify-start">
                    @if(!$activeParent)
                        <div class="flex-1 flex flex-col items-center justify-center py-16 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50/20 dark:bg-gray-800/5">
                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.303-.553l-1.591 1.59M21.75 12h-2.25m-.553 5.303l-1.591-1.59m-10.606 0l-1.59 1.59M2.25 12h2.25m-.553-5.303l1.59 1.59m5.606-2.134V4.5" />
                            </svg>
                            <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">Silakan Pilih Menu Utama</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 max-w-xs px-4">Klik salah satu menu utama di kolom kiri untuk menampilkan dan menyusun sub-menu.</p>
                        </div>
                    @else
                        @if($subMenus->count() > 0)
                            <div class="space-y-3">
                                @foreach($subMenus as $menu)
                                    <div draggable="true"
                                         x-data="{ isOver: false }"
                                         @dragstart="e => { e.dataTransfer.setData('text/plain', {{ $menu->id }}); }"
                                         @dragover="e => { e.preventDefault(); isOver = true; }"
                                         @dragleave="isOver = false"
                                         @drop="e => { isOver = false; $wire.reorderMenus(e.dataTransfer.getData('text/plain'), {{ $menu->id }}); }"
                                         :class="{ 'border-emerald-500 bg-emerald-50/10 ring-2 ring-emerald-500/10': isOver }"
                                         class="relative flex items-center justify-between p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm transition duration-150 hover:shadow-md cursor-pointer select-none">
                                        
                                        <div class="flex items-center gap-4">
                                            <!-- Drag Handle -->
                                            <div class="flex items-center gap-1 text-gray-400 cursor-grab active:cursor-grabbing p-1 hover:text-gray-600 dark:hover:text-gray-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                                                </svg>
                                            </div>
                                            
                                            <div class="flex flex-col">
                                                <span class="font-extrabold text-sm tracking-wide text-gray-900 dark:text-white uppercase">
                                                    {{ $menu->label }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                    {{ $menu->resolved_url }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-2">
                                            <button wire:click.stop="mountAction('editMenu', { id: {{ $menu->id }} })" 
                                                    class="p-2 text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/30 dark:hover:bg-blue-900/40 transition rounded-lg"
                                                    title="Ubah Menu">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button wire:click.stop="mountAction('deleteMenu', { id: {{ $menu->id }} })" 
                                                    class="p-2 text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 dark:bg-red-950/30 dark:hover:bg-red-900/40 transition rounded-lg"
                                                    title="Hapus Menu">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex-1 flex flex-col items-center justify-center py-16 text-center border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50/20 dark:bg-gray-800/5">
                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                <h4 class="text-sm font-bold text-gray-800 dark:text-gray-200">Belum Ada Sub-Menu</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5 max-w-xs px-4">Tekan tombol di atas untuk membuat submenu atau menyeret submenu ke sini.</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
