@extends('layouts.main')

@section('title', $recipe->title . ' - Resep')

@section('content')

    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('recipes.index') }}" 
           class="inline-flex items-center gap-x-2 text-sm font-medium text-[#73726E] hover:text-[#37352F] transition-colors">
            <i class="ph ph-arrow-left"></i> Kembali ke Daftar Resep
        </a>
    </div>

    {{-- Konten Utama Resep --}}
    <div class="bg-white border border-[#E9E9E7] rounded-xl p-6 shadow-sm">
        
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Sisi Kiri: Gambar Resep --}}
            <div class="w-full lg:w-1/2">
                <div class="aspect-video w-full rounded-lg overflow-hidden border border-[#E9E9E7] bg-[#F7F7F5]">
                    @if($recipe->image)
                        <img src="{{ asset('storage/' . $recipe->image) }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $recipe->title }}">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-[#73726E]">
                            <i class="ph ph-image text-4xl text-[#E9E9E7] mb-2"></i>
                            <span class="text-xs italic">Tidak ada foto resep</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Sisi Kanan: Metadata & Info Singkat --}}
            <div class="w-full lg:w-1/2 flex flex-col justify-between">
                <div>
                    {{-- Judul Resep --}}
                    <h1 class="text-3xl font-bold text-[#37352F] mb-2">{{ $recipe->title }}</h1>
                    
                    {{-- Submitter / Pembuat --}}
                    <p class="text-sm text-[#73726E] mb-4 flex items-center gap-x-1.5">
                        <i class="ph ph-user-circle text-base"></i>
                        Oleh <span class="font-semibold text-[#37352F]">{{ $recipe->user->name }}</span>
                    </p>

                    {{-- Rating & Jumlah Review --}}
                    <div class="flex items-center gap-x-2 mb-6">
                        <div class="inline-flex items-center gap-x-1 bg-orange-50 border border-orange-200 text-[#D9730D] px-2.5 py-1 rounded-md text-sm font-bold">
                            <i class="ph-fill ph-star"></i>
                            {{ number_format($avgRating, 1) }}
                        </div>
                        <span class="text-xs text-[#73726E]">({{ $recipe->reviews->count() }} Ulasan)</span>
                    </div>
                </div>

                {{-- Flavor Tags --}}
                <div class="border-t border-[#E9E9E7] pt-4">
                    <h5 class="text-xs font-medium text-[#73726E] uppercase tracking-wider mb-2">Rasa / Karakteristik</h5>
                    <div class="flex flex-wrap gap-1.5">
                        @forelse($recipe->flavors as $flavor)
                            <span class="inline-flex items-center bg-[#F7F7F5] border border-[#E9E9E7] text-[#37352F] text-xs px-2.5 py-1 rounded-md font-medium">
                                {{ $flavor->name }}
                            </span>
                        @empty
                            <span class="text-xs text-[#73726E] italic">Tidak ada tag rasa.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian Bawah: Bahan & Langkah --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 border-t border-[#E9E9E7] mt-8 pt-8">
            
            {{-- Kolom Bahan-bahan (Bobot Grid: 5 dari 12) --}}
            <div class="md:col-span-5">
                <h3 class="text-lg font-bold text-[#37352F] flex items-center gap-x-2 mb-4">
                    <i class="ph ph-basket text-[#D9730D]"></i> Bahan-bahan
                </h3>
                <div class="text-sm text-[#37352F] bg-[#F7F7F5] border border-[#E9E9E7] rounded-lg p-4 leading-relaxed" 
                     style="white-space: pre-line;">{{ $recipe->ingredients }}</div>
            </div>

            {{-- Kolom Langkah Memasak (Bobot Grid: 7 dari 12) --}}
            <div class="md:col-span-7">
                <h3 class="text-lg font-bold text-[#37352F] flex items-center gap-x-2 mb-4">
                    <i class="ph ph-cooking-pot text-[#D9730D]"></i> Langkah Memasak
                </h3>
                <div class="text-sm text-[#37352F] bg-white border border-[#E9E9E7] rounded-lg p-4 leading-relaxed" 
                     style="white-space: pre-line;">{{ $recipe->steps }}</div>
            </div>

        </div>

    </div>

@endsection