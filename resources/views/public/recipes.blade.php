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

    {{-- TAMBAHAN: Form filter pencarian dan flavor --}}
    <form method="GET" action="{{ route('recipes.index') }}"
          class="mb-6 flex flex-col sm:flex-row gap-3">

        <div class="relative flex-1">
            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-[#73726E]"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari resep..."
                   class="w-full pl-9 pr-4 py-2 text-sm border border-[#E9E9E7] rounded-md bg-white text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#D9730D] transition-colors">
        </div>

        <select name="flavor"
                class="text-sm border border-[#E9E9E7] rounded-md bg-white text-[#37352F] px-3 py-2 focus:outline-none focus:border-[#D9730D] transition-colors">
            <option value="">Semua Flavor</option>
            @foreach ($flavors as $flavor)
                <option value="{{ $flavor->id }}" {{ request('flavor') == $flavor->id ? 'selected' : '' }}>
                    {{ $flavor->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="inline-flex items-center gap-x-1.5 bg-[#D9730D] text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-orange-700 transition-colors">
            <i class="ph ph-funnel"></i> Filter
        </button>

        @if (request('search') || request('flavor'))
            <a href="{{ route('recipes.index') }}"
               class="inline-flex items-center gap-x-1.5 bg-white border border-[#E9E9E7] text-[#73726E] px-4 py-2 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                <i class="ph ph-x"></i> Reset
            </a>
        @endif

    </form>

    {{-- Hasil resep --}}
    @if ($recipes->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-[#73726E] text-sm">
            <i class="ph-duotone ph-bowl-food text-5xl text-[#E9E9E7] mb-3"></i>
            <p class="italic">
                @if (request('search') || request('flavor'))
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