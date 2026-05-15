@extends('layouts.main')

@section('title', 'Semua Restaurant')

@section('content')

    {{-- Header halaman — pakai komponen page-header yang sudah ada --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#37352F] flex items-center gap-x-2">
            <i class="ph-fill ph-storefront text-[#2383E2]"></i> Restaurant        
        </h1>
        <p class="mt-1 text-sm text-[#73726E]">Temukan restaurant terbaik dari komunitas.</p>
    </div>

    {{-- Form filter pencarian dan flavor --}}
    @php $selectedFlavors = (array) request('flavors', []); @endphp

    <form id="filterForm" method="GET" action="{{ route('restaurants.index') }}"
          class="mb-6 flex flex-col sm:flex-row gap-3">

        {{-- Search input --}}
        <div class="relative flex-1">
            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-[#73726E]"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari restaurant..."
                   class="w-full pl-9 pr-4 py-2 text-sm border border-[#E9E9E7] rounded-md bg-white text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] transition-colors">
        </div>

        {{-- Filter dropdown button --}}
        <div class="relative" id="filterDropdown">
            <button type="button" id="filterToggle"
                    class="inline-flex items-center gap-x-1.5 border border-[#E9E9E7] px-4 py-2 rounded-md text-sm font-medium transition-colors
                           {{ count($selectedFlavors) ? 'bg-blue-50 text-blue-600 border-blue-200' : 'bg-white text-[#37352F] hover:bg-[#F7F7F5]' }}">
                <i class="ph ph-funnel"></i>
                Filter
                @if (count($selectedFlavors))
                    <span class="grid place-items-center min-w-[1rem] h-4 px-1 rounded-full bg-blue-600 text-white text-[10px] leading-none font-bold">{{ count($selectedFlavors) }}</span>
                @endif
                <i class="ph ph-caret-down text-xs transition-transform duration-200" id="filterCaret"></i>
            </button>

            {{-- Dropdown panel --}}
            <div id="filterPanel"
                 class="hidden absolute right-0 top-full mt-2 w-72 bg-white border border-[#E9E9E7] rounded-lg shadow-lg z-20 p-4 space-y-4">

                {{-- Flavor checkboxes --}}
                <div>
                    <label class="block text-xs font-medium text-[#73726E] uppercase tracking-wider mb-2">Flavor</label>
                    <div class="max-h-48 overflow-y-auto space-y-1 pr-1">
                        @foreach ($flavors as $flavor)
                            <label class="flex items-center gap-x-2.5 px-2 py-1.5 rounded-md cursor-pointer hover:bg-[#F7F7F5] transition-colors">
                                <input type="checkbox" name="flavors[]" value="{{ $flavor->id }}"
                                       {{ in_array($flavor->id, $selectedFlavors) ? 'checked' : '' }}
                                       class="w-3.5 h-3.5 rounded border-[#E9E9E7] text-blue-600 focus:ring-blue-500 focus:ring-offset-0">
                                <span class="text-sm text-[#37352F]">{{ $flavor->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex items-center gap-2 pt-2 border-t border-[#E9E9E7]">
                    @if (request('search') || count($selectedFlavors))
                        <a href="{{ route('restaurants.index') }}"
                           class="flex-1 inline-flex items-center justify-center gap-x-1 bg-white border border-[#E9E9E7] text-[#73726E] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                            <i class="ph ph-x text-xs"></i> Reset
                        </a>
                    @endif
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-x-1 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                        <i class="ph ph-check text-xs"></i> Terapkan
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Toggle script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('filterToggle');
            const panel  = document.getElementById('filterPanel');
            const caret  = document.getElementById('filterCaret');

            toggle.addEventListener('click', function () {
                panel.classList.toggle('hidden');
                caret.classList.toggle('rotate-180');
            });

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', function (e) {
                if (!document.getElementById('filterDropdown').contains(e.target)) {
                    panel.classList.add('hidden');
                    caret.classList.remove('rotate-180');
                }
            });
        });
    </script>

    {{-- Hasil restoran --}}
    @if ($restaurants->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-[#73726E] text-sm">
            <i class="ph-duotone ph-storefront text-5xl text-[#E9E9E7] mb-3"></i>
            <p class="italic">
                @if (request('search') || count($selectedFlavors))
                    Tidak ada restaurant yang cocok dengan filter kamu.
                @else
                    Belum ada restaurant.
                @endif
            </p>
        </div>
    @else
        {{-- Grid kartu restoran, pakai komponen card-restaurant yang sudah ada --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($restaurants as $restaurant)
                <x-card-restaurant
                    :restaurant="$restaurant"
                    :href="route('restaurants.show', $restaurant)" />
            @endforeach
        </div>

        <div class="mt-6">
            {{ $restaurants->links() }}
        </div>
    @endif

@endsection

