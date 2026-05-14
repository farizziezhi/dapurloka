@extends('layouts.main')

@section('title', 'Beranda')

@section('hero')
    <section class="relative overflow-hidden border-b border-[#E9E9E7] bg-[#F7F7F5]">
        <div class="absolute inset-0 dapur-grid-bg opacity-50 pointer-events-none"></div>
        <div class="absolute -top-32 -left-24 w-72 h-72 rounded-full bg-[#FAEBDD] blur-3xl opacity-60 pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-24 w-80 h-80 rounded-full bg-[#EAE4F2] blur-3xl opacity-60 pointer-events-none"></div>

        <div class="relative max-w-3xl mx-auto px-4 py-16 sm:py-20 text-center">
            <span class="inline-flex items-center gap-x-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-white text-[#6940A5] border border-[#EAE4F2]">
                <i class="ph-fill ph-sparkle"></i> Powered by Laravel AI
            </span>

            <h1 class="mt-5 text-5xl sm:text-7xl font-bold tracking-tight leading-[1.05]">
                <span class="dapur-wordmark">Dapurloka</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg text-[#73726E] leading-relaxed max-w-xl mx-auto">
                Lagi pengen makan apa? Ceritakan kondisimu &mdash;
                <span class="text-[#37352F] font-medium">biarkan kami sarankan resep atau restoran yang pas.</span>
            </p>

            {{-- AI input card --}}
            <form method="POST" action="{{ url('/ai/suggest') }}" class="mt-8 text-left max-w-2xl mx-auto">
                @csrf
                <div class="bg-white border border-[#E9E9E7] rounded-lg p-3 shadow-sm focus-within:border-[#2383E2] focus-within:ring-2 focus-within:ring-[#2383E2]/20 transition-all">
                    <div class="flex items-start gap-x-3">
                        <span class="grid place-items-center w-9 h-9 shrink-0 rounded-md bg-[#EAE4F2] text-[#6940A5]">
                            <i class="ph-bold ph-sparkle"></i>
                        </span>
                        <textarea name="prompt" rows="2"
                                  class="flex-1 bg-transparent text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none resize-none pt-1.5"
                                  placeholder="Contoh: Lagi flu, butuh sesuatu yang hangat dan ringan...">{{ old('prompt') }}</textarea>
                    </div>

                    <div class="mt-2 flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-[#E9E9E7]">
                        <div class="flex items-center gap-x-1.5 text-xs text-[#73726E]">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#0F7B6C] opacity-60"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#0F7B6C]"></span>
                            </span>
                            AI siap menjawab
                        </div>
                        <button type="submit"
                                class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                            <i class="ph-bold ph-paper-plane-tilt"></i> Sarankan
                        </button>
                    </div>
                </div>
            </form>

            {{-- Suggestion chips --}}
            <div class="mt-5 flex flex-wrap items-center justify-center gap-2 text-xs">
                <span class="text-[#73726E]">Coba:</span>
                @foreach ([
                    ['icon' => 'ph-fill ph-thermometer-hot', 'text' => 'Sedang flu, mau hangat', 'color' => 'text-[#EB5757]'],
                    ['icon' => 'ph-fill ph-sun',             'text' => 'Cuaca panas, segar',     'color' => 'text-[#CB912F]'],
                    ['icon' => 'ph-fill ph-heart',           'text' => 'Ingin yang manis',       'color' => 'text-[#C14C8A]'],
                ] as $chip)
                    <button type="button" form-prefill data-prompt="{{ $chip['text'] }}"
                            class="inline-flex items-center gap-x-1.5 px-2.5 py-1 rounded-full bg-white border border-[#E9E9E7] hover:bg-[#F7F7F5] hover:border-[#73726E]/30 transition-colors">
                        <i class="{{ $chip['icon'] }} {{ $chip['color'] }}"></i>
                        <span class="text-[#37352F]">{{ $chip['text'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('content')
    {{-- Featured Recipes --}}
    <section class="mt-2 mb-12">
        <div class="flex items-end justify-between mb-5 pb-3 border-b border-[#E9E9E7]">
            <div class="flex items-start gap-x-3">
                <span class="grid place-items-center w-9 h-9 rounded-md bg-[#FBE4E4] text-[#BE4D52]">
                    <i class="ph-fill ph-bowl-food"></i>
                </span>
                <div>
                    <h2 class="text-lg font-semibold text-[#37352F]">Resep Pilihan</h2>
                    <p class="text-sm text-[#73726E]">Resep terbaru yang sudah disetujui komunitas.</p>
                </div>
            </div>
            <a href="#" class="inline-flex items-center gap-x-1 text-sm text-[#2383E2] hover:underline">
                Lihat semua <i class="ph-bold ph-arrow-right"></i>
            </a>
        </div>

        @if ($featuredRecipes->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                <i class="ph-duotone ph-bowl-food text-4xl text-[#E9E9E7] mb-2"></i>
                <p class="italic">Belum ada resep yang ditampilkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($featuredRecipes as $recipe)
                    <x-card-recipe :recipe="$recipe" href="#" />
                @endforeach
            </div>
        @endif
    </section>

    {{-- Top Restaurants --}}
    <section class="mb-16">
        <div class="flex items-end justify-between mb-5 pb-3 border-b border-[#E9E9E7]">
            <div class="flex items-start gap-x-3">
                <span class="grid place-items-center w-9 h-9 rounded-md bg-[#DDEBF1] text-[#2383E2]">
                    <i class="ph-fill ph-storefront"></i>
                </span>
                <div>
                    <h2 class="text-lg font-semibold text-[#37352F]">Restoran Pilihan</h2>
                    <p class="text-sm text-[#73726E]">Tempat makan yang kami rekomendasikan.</p>
                </div>
            </div>
            <a href="#" class="inline-flex items-center gap-x-1 text-sm text-[#2383E2] hover:underline">
                Lihat semua <i class="ph-bold ph-arrow-right"></i>
            </a>
        </div>

        @if ($topRestaurants->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                <i class="ph-duotone ph-storefront text-4xl text-[#E9E9E7] mb-2"></i>
                <p class="italic">Belum ada restoran yang ditampilkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($topRestaurants as $restaurant)
                    <x-card-restaurant :restaurant="$restaurant" href="#" />
                @endforeach
            </div>
        @endif
    </section>
@endsection
