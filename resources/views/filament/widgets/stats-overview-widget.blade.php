{{-- filepath: /c:/spindo/WebPKL/resources/views/filament/widgets/stats-overview-widget.blade.php --}}
@php
    $data = $this->getViewData();
@endphp

@pushOnce('styles')
    @vite(['resources/css/widgets.css'])
@endPushOnce

@pushOnce('scripts')
    @vite(['resources/js/widgets.js'])
@endPushOnce

<x-filament-widgets::widget>
    <div class="space-y-6" x-data="{ animateNumbers: true }">

        {{-- Header with Gradient Animation --}}
        <div class="gradient-animated bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 rounded-2xl p-6 shadow-2xl">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="text-white">
                    <h3 class="text-3xl font-bold flex items-center gap-3 mb-2">
                        <span class="text-4xl float-animation">📊</span>
                        <span>Dashboard Statistik Packing</span>
                    </h3>
                    <p class="text-white/90 text-sm">Real-time monitoring & analytics</p>
                    <div class="progress-bar mt-3 rounded-full"></div>
                </div>
                <div class="glass rounded-xl px-6 py-3 backdrop-blur-lg">
                    <p class="text-white text-xs font-medium mb-1">Tanggal Operasional</p>
                    <p class="text-white text-3xl font-bold tracking-tight">
                        {{ $data['selectedDate']->format('d M Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">

            {{-- Card 1: Total Laporan --}}
            <div class="stats-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 100)">

                <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 p-6 relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-white/90 text-sm font-medium mb-2">📋 Total Laporan</p>
                                <h3 class="text-5xl font-bold text-white number-counter counter-value"
                                    data-target="{{ $data['todayReports'] }}"
                                    x-show="show"
                                    x-transition:enter="counter-animate">
                                    0
                                </h3>
                                <p class="text-blue-100 text-xs mt-2">Periode: 07:00 - 06:59</p>
                            </div>
                            <div class="icon-rotate">
                                <svg class="w-14 h-14 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-700 dark:to-gray-600 border-t-2 border-blue-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">Trend 7 Hari Terakhir</span>
                    </div>
                </div>
            </div>

            {{-- Card 2: Shift Saat Ini --}}
            <div class="stats-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden card-pulse"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 200)">

                @php
                    $shiftGradient = match($data['currentShift']) {
                        1 => 'from-cyan-500 via-cyan-600 to-cyan-700',
                        2 => 'from-orange-500 via-orange-600 to-orange-700',
                        3 => 'from-indigo-500 via-indigo-600 to-indigo-700',
                        default => 'from-gray-500 via-gray-600 to-gray-700'
                    };
                @endphp

                <div class="bg-gradient-to-br {{ $shiftGradient }} p-6 relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-white/90 text-sm font-medium mb-2">⏰ Shift Aktif</p>
                                <h3 class="text-5xl font-bold text-white"
                                    x-show="show"
                                    x-transition:enter="counter-animate">
                                    Shift {{ $data['currentShift'] }}
                                </h3>
                                <p class="text-white/80 text-xs mt-2">{{ $data['currentShiftReports'] }} laporan aktif</p>
                            </div>
                            <div class="icon-rotate">
                                <svg class="w-14 h-14 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-r from-{{ $data['shiftColor'] }}-50 to-{{ $data['shiftColor'] }}-100 dark:from-gray-700 dark:to-gray-600 border-t-2 border-{{ $data['shiftColor'] }}-200">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-200">
                        {!! str_replace(['🌅', '🌆', '🌙'], ['<span class="text-2xl inline-block">🌅</span>', '<span class="text-2xl inline-block">🌆</span>', '<span class="text-2xl inline-block">🌙</span>'], $data['shiftDescription']) !!}
                    </p>
                </div>
            </div>

            {{-- Card 3: Total Qty GI --}}
            <div class="stats-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 300)">

                <div class="bg-gradient-to-br from-green-500 via-green-600 to-emerald-700 p-6 relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-white/90 text-sm font-medium mb-2">📦 Total Qty GI</p>
                                <h3 class="text-4xl font-bold text-white number-counter counter-value"
                                    data-target="{{ $data['totalQtyGI'] }}"
                                    x-show="show"
                                    x-transition:enter="counter-animate">
                                    0
                                </h3>
                                <p class="text-green-100 text-xs mt-2">
                                    GR: {{ number_format($data['totalQtyGR']) }} pcs ({{ $data['grPercentage'] }}%)
                                </p>
                            </div>
                            <div class="icon-rotate">
                                <svg class="w-14 h-14 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-100 dark:from-gray-700 dark:to-gray-600 border-t-2 border-green-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Produktivitas</span>
                        <span class="badge-bounce inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                            +{{ $data['grPercentage'] }}% ↗
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card 4: Qty Reject --}}
            <div class="stats-card bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 400)">

                @php
                    $rejectGradient = $data['rejectPercentage'] > 5
                        ? 'from-red-500 via-red-600 to-red-700'
                        : ($data['rejectPercentage'] > 2
                            ? 'from-yellow-500 via-yellow-600 to-orange-600'
                            : 'from-green-500 via-green-600 to-emerald-700');
                @endphp

                <div class="bg-gradient-to-br {{ $rejectGradient }} p-6 relative">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                    <div class="relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <p class="text-white/90 text-sm font-medium mb-2">⚠️ Qty Reject</p>
                                <h3 class="text-4xl font-bold text-white number-counter counter-value"
                                    data-target="{{ $data['totalQtyReject'] }}"
                                    x-show="show"
                                    x-transition:enter="counter-animate">
                                    0
                                </h3>
                                <p class="text-white/80 text-xs mt-2 percentage-value" data-value="{{ $data['rejectPercentage'] }}">
                                    Rate: {{ $data['rejectPercentage'] }}%
                                </p>
                            </div>
                            <div class="icon-rotate">
                                <svg class="w-14 h-14 text-white/30" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 border-t-2 border-gray-200">
                    <div class="flex items-center gap-2">
                        @if($data['rejectPercentage'] <= 2)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-500 text-white shadow-md badge-bounce">
                                ✓ Excellent
                            </span>
                        @elseif($data['rejectPercentage'] <= 5)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-500 text-white shadow-md badge-bounce">
                                ⚠ Warning
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-500 text-white shadow-md badge-bounce">
                                ✕ Critical
                            </span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-filament-widgets::widget>