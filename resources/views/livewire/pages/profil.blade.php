<div class="pt-24 pb-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden p-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center border-b pb-4">Profil & Sejarah Perpustakaan</h1>
            
            @if($profile)
                @if($profile->tagline)
                    <div class="mb-8 text-center">
                        <p class="text-xl text-emerald-600 dark:text-emerald-400 font-semibold italic">"{{ $profile->tagline }}"</p>
                    </div>
                @endif

                <div class="grid md:grid-cols-2 gap-10">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Visi</h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-lg mb-6">
                            <p class="text-gray-700 dark:text-gray-300">{{ $profile->visi }}</p>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Misi</h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-lg">
                            <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                                @foreach($profile->misi as $misi)
                                    @php
                                        if (is_array($misi)) {
                                            $text = $misi['item'] ?? $misi['value'] ?? json_encode($misi);
                                        } elseif (is_string($misi)) {
                                            $decoded = json_decode($misi, true);
                                            $text = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) 
                                                ? ($decoded['item'] ?? $decoded['value'] ?? $misi) 
                                                : $misi;
                                        } else {
                                            $text = $misi;
                                        }
                                    @endphp
                                    <li class="flex items-start gap-2">
                                        <span class="text-emerald-500 mt-1 text-xs">●</span>
                                        <span class="text-justify">{{ $text }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Tugas Pokok</h2>
                         <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-lg mb-6">
                            <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                @foreach($profile->tasks ?? [] as $task)
                                    @php
                                        $decoded = is_string($task) ? json_decode($task, true) : $task;
                                        $isArray = is_array($decoded);
                                    @endphp
                                    <li>
                                        @if($isArray && isset($decoded['title']))
                                            <span class="font-semibold">{{ $decoded['title'] }}</span>
                                            @if(isset($decoded['description']))
                                                @php
                                                    $descText = html_entity_decode(strip_tags($decoded['description']));
                                                    $descText = preg_replace('/\x{00A0}/u', "\n", $descText);
                                                    $descLines = preg_split('/\r?\n/', $descText);
                                                    $descLines = array_values(array_filter(array_map('trim', $descLines)));
                                                @endphp
                                                @if(count($descLines) > 0)
                                                    <ul class="mt-2 ml-6 space-y-1 text-sm">
                                                        @foreach($descLines as $line)
                                                            <li class="flex items-start gap-2">
                                                                <span class="text-emerald-500 mt-1 text-xs">●</span>
                                                                <span>{{ $line }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endif
                                        @elseif($isArray)
                                            {{ $decoded['item'] ?? $decoded['value'] ?? json_encode($decoded) }}
                                        @else
                                            {{ $task }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Fungsi</h2>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 p-6 rounded-lg">
                             <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                                @foreach($profile->functions ?? [] as $function)
                                    @php
                                        $decoded = is_string($function) ? json_decode($function, true) : $function;
                                        $isArray = is_array($decoded);
                                    @endphp
                                    <li>
                                        @if($isArray && isset($decoded['title']))
                                            <span class="font-semibold">{{ $decoded['title'] }}</span>
                                            @if(isset($decoded['description']))
                                                @php
                                                    $descText = html_entity_decode(strip_tags($decoded['description']));
                                                    $descText = preg_replace('/\x{00A0}/u', "\n", $descText);
                                                    $descLines = preg_split('/\r?\n/', $descText);
                                                    $descLines = array_values(array_filter(array_map('trim', $descLines)));
                                                @endphp
                                                @if(count($descLines) > 0)
                                                    <ul class="mt-2 ml-6 space-y-1 text-sm">
                                                        @foreach($descLines as $line)
                                                            <li class="flex items-start gap-2">
                                                                <span class="text-emerald-500 mt-1 text-xs">●</span>
                                                                <span>{{ $line }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endif
                                        @elseif($isArray)
                                            {{ $decoded['item'] ?? $decoded['value'] ?? json_encode($decoded) }}
                                        @else
                                            {{ $function }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                @if(!empty($profile->milestones))
                    <div class="mt-16 mb-16 relative">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-10 text-center">Sejarah & Milestone</h2>
                        <div class="relative wrap overflow-hidden p-4 h-full">
                            <div class="absolute border-opacity-20 border-gray-700 h-full border-2 left-1/2 transform -translate-x-1/2"></div>
                            
                            @foreach($profile->milestones as $index => $milestone)
                                @php
                                    $data = is_string($milestone) ? json_decode($milestone, true) : $milestone;
                                    $isRight = $index % 2 !== 0; 
                                @endphp
                                <div class="mb-8 flex justify-between items-center w-full {{ $isRight ? 'flex-row-reverse' : '' }}">
                                    <div class="order-1 w-5/12"></div>
                                    <div class="z-20 flex items-center order-1 bg-emerald-600 shadow-xl w-8 h-8 rounded-full border-4 border-white dark:border-gray-800">
                                        <h1 class="mx-auto font-semibold text-lg text-white"></h1>
                                    </div>
                                    <div class="order-1 bg-white dark:bg-gray-700 rounded-lg shadow-md w-5/12 px-6 py-4 border border-gray-100 dark:border-gray-600">
                                        <h3 class="mb-2 font-bold text-gray-800 dark:text-white text-xl">
                                            <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">{{ $data['year'] ?? '' }}</span> 
                                            - {{ $data['title'] ?? '' }}
                                        </h3>
                                        <p class="text-sm leading-snug tracking-wide text-gray-600 dark:text-gray-300">
                                            {{ $data['description'] ?? '' }}
                                        </p>
                                        @if(isset($data['image_path']) && $data['image_path'])
                                            <div class="mt-4">
                                                <img src="{{ asset('storage/' . $data['image_path']) }}" alt="{{ $data['title'] ?? '' }}" class="rounded-lg shadow-sm w-full object-cover">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                 @if(!empty($profile->collections))
                    <div class="mt-10">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 text-center">Koleksi Kami</h2>
                        <div class="flex flex-wrap justify-center gap-6">
                            @foreach($profile->collections as $collection)
                                <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg w-full sm:w-[45%] md:w-[22%] text-center shadow-sm">
                                    @php
                                        if (is_array($collection)) {
                                            $data = $collection;
                                        } elseif (is_string($collection)) {
                                            $decoded = json_decode($collection, true);
                                            $data = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : null;
                                        } else {
                                            $data = null;
                                        }
                                    @endphp
                                    
                                    @if($data && isset($data['category']))
                                        <div class="flex flex-col items-center">
                                            <span class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400">{{ $data['quantity'] ?? '0' }}</span>
                                            <span class="font-medium text-gray-700 dark:text-gray-300 mt-1">{{ $data['category'] }}</span>
                                            @if(isset($data['title']) && $data['category'] !== $data['title'])
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $data['title'] }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="block font-bold text-gray-900 dark:text-white">{{ is_string($collection) ? $collection : json_encode($collection) }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-10 text-gray-500">
                    <p>Profil belum tersedia.</p>
                </div>
            @endif
        </div>
    </div>
</div>
