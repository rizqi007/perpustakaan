@php
    $record = $getRecord();
    $data = $record->data;
@endphp

<div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm bg-white dark:bg-gray-800">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-left border-collapse">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/3">Pertanyaan / Input</th>
                <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jawaban / Isian</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
            <!-- Row: Pengirim -->
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                <td class="px-6 py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">Pengirim</td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-bold">{{ $record->user->name ?? 'User Dihapus' }}</td>
            </tr>
            @if(is_array($data))
                @foreach($data as $key => $value)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $key }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                            @if(is_string($value) && \Illuminate\Support\Str::startsWith($value, 'form_submissions/'))
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($value) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-xs font-semibold rounded-lg hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition shadow-xs">
                                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Unduh Dokumen
                                </a>
                            @else
                                <span class="whitespace-pre-line leading-relaxed">{{ $value ?: '-' }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
