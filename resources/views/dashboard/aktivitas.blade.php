<div id="aktivitas-container">

    <div class="overflow-hidden rounded-3xl border border-slate-200">

        <table class="w-full">

            <thead class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white">

                <tr>

                    <th class="px-5 py-4 w-16 text-left">
                        No
                    </th>

                    <th class="px-5 py-4 text-left">
                        Aktivitas
                    </th>

                    <th class="px-5 py-4 text-left">
                        Deskripsi
                    </th>

                    <th class="px-5 py-4 text-left w-48">
                        Waktu
                    </th>

                    <th class="px-5 py-4 text-center w-44">
                        Status
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($aktivitas as $index => $item)

                <tr class="aktivitas-row border-b border-slate-100 hover:bg-blue-50 transition">

                    {{-- Nomor --}}
                    <td class="px-5 py-5">

                        <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center">

                            {{ $aktivitas->firstItem() + $index }}

                        </div>

                    </td>

                    {{-- Aktivitas --}}
                    <td class="px-5 py-5">

                        <div class="flex items-center gap-4">

                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center shadow">

                                @php

                                    $icon = match($item['status']){

                                        'Disetujui' => 'badge-check',

                                        'Ditolak' => 'x-circle',

                                        'Menunggu',
                                        'Menunggu Approval KPP',
                                        'Menunggu Approval KTU',
                                        'Menunggu Approval Kepala'
                                            => 'clock-3',

                                        'Disposisi'
                                            => 'send',

                                        'Arsip'
                                            => 'archive',

                                        default
                                            => 'mail'

                                    };

                                @endphp

                                <i data-lucide="{{ $icon }}"
                                   class="w-5 h-5 text-white">
                                </i>

                            </div>

                            <div>

                                <div class="font-bold text-slate-800">

                                    {{ $item['judul'] }}

                                </div>

                            </div>

                        </div>

                    </td>

                    {{-- Deskripsi --}}
                    <td class="px-5 py-5 text-slate-500">

                        {{ $item['deskripsi'] }}

                    </td>

                    {{-- Waktu --}}
                    <td class="px-5 py-5 whitespace-nowrap">

                        <div class="font-semibold text-slate-700">

                            {{ $item['waktu']->timezone('Asia/Makassar')->format('d M Y') }}

                        </div>

                        <div class="text-xs text-slate-400 mt-1">

                            {{ $item['waktu']->timezone('Asia/Makassar')->format('H:i') }}

                        </div>

                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-5 text-center">

                        @php

                            $class = match($item['status']){

                                'Baru'
                                    => 'bg-blue-100 text-blue-700',

                                'Menunggu',
                                'Menunggu Approval KPP',
                                'Menunggu Approval KTU',
                                'Menunggu Approval Kepala'
                                    => 'bg-yellow-100 text-yellow-700',

                                'Disetujui'
                                    => 'bg-green-100 text-green-700',

                                'Ditolak'
                                    => 'bg-red-100 text-red-700',

                                'Disposisi'
                                    => 'bg-purple-100 text-purple-700',

                                'Arsip'
                                    => 'bg-orange-100 text-orange-700',

                                default
                                    => 'bg-slate-100 text-slate-700'

                            };

                        @endphp

                        <span class="px-4 py-2 rounded-full text-xs font-bold {{ $class }}">

                            {{ $item['status'] }}

                        </span>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5">

                        <div class="py-20 flex flex-col items-center">

                            <i data-lucide="inbox"
                               class="w-14 h-14 text-slate-300">
                            </i>

                            <h3 class="mt-5 text-lg font-bold text-slate-600">

                                Belum Ada Aktivitas

                            </h3>

                            <p class="text-slate-400 mt-2">

                                Aktivitas pengguna akan muncul di sini.

                            </p>

                        </div>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    @if($aktivitas->hasPages())

        <div class="flex justify-center gap-2 mt-8">

            {{-- Previous --}}
            @if($aktivitas->onFirstPage())

                <span class="w-10 h-10 rounded-xl bg-slate-200 text-slate-400 flex items-center justify-center">

                    <i class="bi bi-chevron-left"></i>

                </span>

            @else

                <a href="{{ $aktivitas->previousPageUrl() }}"
                   class="pagination-link w-10 h-10 rounded-xl border bg-white hover:bg-blue-600 hover:text-white transition flex items-center justify-center">

                    <i class="bi bi-chevron-left"></i>

                </a>

            @endif

            {{-- Nomor --}}
            @foreach($aktivitas->getUrlRange(1,$aktivitas->lastPage()) as $page=>$url)

                <a href="{{ $url }}"
                   class="pagination-link w-10 h-10 rounded-xl flex items-center justify-center font-semibold transition

                   {{ $page==$aktivitas->currentPage()

                   ? 'bg-blue-600 text-white shadow-lg'

                   : 'bg-white border hover:bg-blue-50' }}">

                    {{ $page }}

                </a>

            @endforeach

            {{-- Next --}}
            @if($aktivitas->hasMorePages())

                <a href="{{ $aktivitas->nextPageUrl() }}"
                   class="pagination-link w-10 h-10 rounded-xl border bg-white hover:bg-blue-600 hover:text-white transition flex items-center justify-center">

                    <i class="bi bi-chevron-right"></i>

                </a>

            @else

                <span class="w-10 h-10 rounded-xl bg-slate-200 text-slate-400 flex items-center justify-center">

                    <i class="bi bi-chevron-right"></i>

                </span>

            @endif

        </div>

    @endif

</div>