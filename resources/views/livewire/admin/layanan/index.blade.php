<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Manajemen Layanan</h1>
            <a href="{{ route('admin.layanan.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition-colors">
                Tambah Layanan
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Icon/Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Layanan</th>
                             <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">URL Redirect</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($layanans as $layanan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($layanan->image)
                                        <img src="{{ asset('storage/' . $layanan->image) }}" alt="Icon" class="h-10 w-10 object-contain rounded">
                                    @else
                                        <div class="h-10 w-10 bg-gray-200 flex items-center justify-center text-gray-400 text-xs rounded">No Icon</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $layanan->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ $layanan->url }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900 truncate block max-w-xs">{{ $layanan->url }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.layanan.edit', $layanan->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <button wire:click="delete({{ $layanan->id }})" wire:confirm="Apakah Anda yakin ingin menghapus layanan ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    Belum ada layanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                {{ $layanans->links() }}
            </div>
        </div>
    </div>
</div>
