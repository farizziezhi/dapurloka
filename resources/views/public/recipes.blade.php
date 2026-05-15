{{-- ============================================================ --}}
{{-- FILE BARU — halaman publik daftar resep yang sudah approved  --}}
{{-- ============================================================ --}}

@extends('layouts.main')

@section('title', 'Resep')

@section('content')

    {{-- Header halaman --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#37352F] flex items-center gap-x-2">
            <i class="ph-fill ph-bowl-food text-[#D9730D]"></i> Resep
        </h1>
        <p class="mt-1 text-sm text-[#73726E]">Temukan resep masakan pilihan dari komunitas Dapurloka.</p>
    </div>

    {{-- Form filter pencarian dan flavor --}}
    @php $selectedFlavors = (array) request('flavors', []); @endphp

    <form id="recipeFilterForm" method="GET" action="{{ route('recipes.index') }}"
          class="mb-6 flex flex-col sm:flex-row gap-3">

        {{-- Search input --}}
        <div class="relative flex-1">
            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-[#73726E]"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari resep..."
                   class="w-full pl-9 pr-4 py-2 text-sm border border-[#E9E9E7] rounded-md bg-white text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#D9730D] transition-colors">
        </div>

        {{-- Filter dropdown button --}}
        <div class="relative" id="recipeFilterDropdown">
            <button type="button" id="recipeFilterToggle"
                    class="inline-flex items-center gap-x-1.5 border border-[#E9E9E7] px-4 py-2 rounded-md text-sm font-medium transition-colors
                           {{ count($selectedFlavors) ? 'bg-orange-50 text-[#D9730D] border-orange-200' : 'bg-white text-[#37352F] hover:bg-[#F7F7F5]' }}">
                <i class="ph ph-funnel"></i>
                Filter
                @if (count($selectedFlavors))
                    <span class="grid place-items-center min-w-[1rem] h-4 px-1 rounded-full bg-[#D9730D] text-white text-[10px] leading-none font-bold">{{ count($selectedFlavors) }}</span>
                @endif
                <i class="ph ph-caret-down text-xs transition-transform duration-200" id="recipeFilterCaret"></i>
            </button>

            {{-- Dropdown panel --}}
            <div id="recipeFilterPanel"
                 class="hidden absolute right-0 top-full mt-2 w-72 bg-white border border-[#E9E9E7] rounded-lg shadow-lg z-20 p-4 space-y-4">

                {{-- Flavor checkboxes --}}
                <div>
                    <label class="block text-xs font-medium text-[#73726E] uppercase tracking-wider mb-2">Flavor</label>
                    <div class="max-h-48 overflow-y-auto space-y-1 pr-1">
                        @foreach ($flavors as $flavor)
                            <label class="flex items-center gap-x-2.5 px-2 py-1.5 rounded-md cursor-pointer hover:bg-[#F7F7F5] transition-colors">
                                <input type="checkbox" name="flavors[]" value="{{ $flavor->id }}"
                                       {{ in_array($flavor->id, $selectedFlavors) ? 'checked' : '' }}
                                       class="w-3.5 h-3.5 rounded border-[#E9E9E7] text-[#D9730D] focus:ring-[#D9730D] focus:ring-offset-0">
                                <span class="text-sm text-[#37352F]">{{ $flavor->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex items-center gap-2 pt-2 border-t border-[#E9E9E7]">
                    @if (request('search') || count($selectedFlavors))
                        <a href="{{ route('recipes.index') }}"
                           class="flex-1 inline-flex items-center justify-center gap-x-1 bg-white border border-[#E9E9E7] text-[#73726E] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                            <i class="ph ph-x text-xs"></i> Reset
                        </a>
                    @endif
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-x-1 bg-[#D9730D] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-orange-700 transition-colors">
                        <i class="ph ph-check text-xs"></i> Terapkan
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Toggle script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('recipeFilterToggle');
            const panel  = document.getElementById('recipeFilterPanel');
            const caret  = document.getElementById('recipeFilterCaret');

            toggle.addEventListener('click', function () {
                panel.classList.toggle('hidden');
                caret.classList.toggle('rotate-180');
            });

            document.addEventListener('click', function (e) {
                if (!document.getElementById('recipeFilterDropdown').contains(e.target)) {
                    panel.classList.add('hidden');
                    caret.classList.remove('rotate-180');
                }
            });
        });
    </script>

    {{-- Hasil resep --}}
    @if ($recipes->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-[#73726E] text-sm">
            <i class="ph-duotone ph-bowl-food text-5xl text-[#E9E9E7] mb-3"></i>
            <p class="italic">
                @if (request('search') || count($selectedFlavors))
                    Tidak ada resep yang cocok dengan filter kamu.
                @else
                    Belum ada resep yang tersedia.
                @endif
            </p>
        </div>
    @else
        {{-- Grid kartu resep, pakai komponen card-recipe yang sudah ada --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($recipes as $recipe)
                <x-card-recipe
                    :recipe="$recipe"
                    href="{{ url('/recipes/' . $recipe->id) }}"
                />
            @endforeach
        </div>

        <div class="mt-6">
            {{ $recipes->links() }}
        </div>
    @endif

@endsection