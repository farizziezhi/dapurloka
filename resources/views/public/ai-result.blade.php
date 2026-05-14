@extends('layouts.main')

@section('title', 'Saran AI')

@section('content')
    <div class="max-w-5xl mx-auto">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-x-1 text-sm text-[#73726E] hover:text-[#37352F] transition-colors">
            <i class="ph-bold ph-arrow-left"></i> Kembali ke beranda
        </a>

        {{-- Header --}}
        <div class="mt-4 flex items-center gap-x-3">
            <span class="grid place-items-center w-10 h-10 rounded-md bg-[#EAE4F2] text-[#6940A5] border border-[#E9E9E7]">
                <i class="ph-fill ph-sparkle text-lg"></i>
            </span>
            <div>
                <h1 class="text-2xl font-bold text-[#37352F] tracking-tight">Saran untuk kamu</h1>
                <p class="text-sm text-[#73726E]">Hasil dari Dapur AI berdasarkan permintaanmu.</p>
            </div>
        </div>

        {{-- User's prompt --}}
        <div class="mt-6 bg-[#F7F7F5] border border-[#E9E9E7] rounded-md p-4 text-sm text-[#37352F]">
            <p class="text-xs uppercase tracking-wide text-[#73726E] flex items-center gap-x-1">
                <i class="ph ph-quotes"></i> Permintaan
            </p>
            <p class="mt-1 whitespace-pre-line">{{ $prompt }}</p>
        </div>

        {{-- Intro --}}
            @if (! empty($intro))
                <p class="mt-6 text-sm text-[#37352F] leading-relaxed flex items-start gap-x-2">
                    <span class="grid place-items-center w-6 h-6 shrink-0 rounded bg-[#EAE4F2] text-[#6940A5] mt-0.5">
                        <i class="ph-fill ph-sparkle text-xs"></i>
                    </span>
                    <span>{{ $intro }}</span>
                </p>
            @endif

            {{-- Recommended recipes --}}
            @if ($recipes->isNotEmpty())
                <section class="mt-8">
                    <div class="flex items-end justify-between mb-4 pb-2 border-b border-[#E9E9E7]">
                        <h2 class="text-base font-semibold text-[#37352F] flex items-center gap-x-2">
                            <span class="grid place-items-center w-7 h-7 rounded-md bg-[#FBE4E4] text-[#BE4D52]">
                                <i class="ph-fill ph-bowl-food text-sm"></i>
                            </span>
                            Resep yang disarankan
                        </h2>
                        <span class="text-xs text-[#73726E]">{{ $recipes->count() }} pilihan</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($recipes as $recipe)
                            <x-card-recipe :recipe="$recipe" href="#" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Recommended restaurants --}}
            @if ($restaurants->isNotEmpty())
                <section class="mt-8">
                    <div class="flex items-end justify-between mb-4 pb-2 border-b border-[#E9E9E7]">
                        <h2 class="text-base font-semibold text-[#37352F] flex items-center gap-x-2">
                            <span class="grid place-items-center w-7 h-7 rounded-md bg-[#DDEBF1] text-[#2383E2]">
                                <i class="ph-fill ph-storefront text-sm"></i>
                            </span>
                            Restoran yang disarankan
                        </h2>
                        <span class="text-xs text-[#73726E]">{{ $restaurants->count() }} pilihan</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($restaurants as $restaurant)
                            <x-card-restaurant :restaurant="$restaurant" href="#" />
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- Empty state when AI returned no picks --}}
            @if ($recipes->isEmpty() && $restaurants->isEmpty())
                <div class="mt-8 flex flex-col items-center justify-center py-12 text-[#73726E] text-sm border border-dashed border-[#E9E9E7] rounded-md">
                    <i class="ph-duotone ph-magnifying-glass text-4xl text-[#E9E9E7] mb-2"></i>
                    <p class="italic max-w-md text-center">
                        Belum ada resep atau restoran di Dapurloka yang cocok dengan permintaanmu.
                        Coba ubah kondisinya, ya.
                    </p>
                </div>
            @endif

            {{-- Closing --}}
            @if (! empty($closing))
                <p class="mt-8 text-sm text-[#73726E] italic text-center">{{ $closing }}</p>
            @endif

        {{-- Footer actions --}}
        <div class="mt-8 flex items-center justify-between gap-x-2 pt-6 border-t border-[#E9E9E7]">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-x-1.5 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Coba lagi
            </a>
            <p class="text-xs text-[#73726E] flex items-center gap-x-1">
                <i class="ph ph-info"></i> Saran berasal dari resep & restoran di Dapurloka.
            </p>
        </div>
    </div>
@endsection
