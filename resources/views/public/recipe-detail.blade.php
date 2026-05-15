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

                    {{-- AI Description (on-demand via button) --}}
                    @if (session('aiDescription'))
                        <div class="bg-[#EAE4F2]/30 border border-[#EAE4F2] rounded-md px-4 py-3 mb-4">
                            <p class="text-xs uppercase tracking-wide text-[#6940A5] flex items-center gap-x-1.5 mb-1">
                                <i class="ph-fill ph-sparkle"></i> Deskripsi oleh Dapur AI
                            </p>
                            <p class="text-sm text-[#37352F] leading-relaxed">{{ session('aiDescription') }}</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('recipes.ai-description', $recipe) }}" class="mb-4">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center gap-x-1.5 bg-[#EAE4F2] text-[#6940A5] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#EAE4F2]/70 transition-colors border border-[#EAE4F2]">
                                <i class="ph-bold ph-sparkle"></i> Generate Deskripsi AI
                            </button>
                        </form>
                    @endif

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

    {{-- Section Ulasan --}}
    <section class="mt-8 bg-white border border-[#E9E9E7] rounded-xl p-6 shadow-sm">
        <h2 class="text-lg font-bold text-[#37352F] flex items-center gap-x-2 mb-4">
            <i class="ph-fill ph-chat-circle-dots text-[#D9730D]"></i>
            Ulasan ({{ $recipe->reviews->count() }})
        </h2>

        {{-- Form tulis review --}}
        @auth
            @php
                $alreadyReviewed = $recipe->reviews->contains('user_id', auth()->id());
                $isOwner = $recipe->user_id === auth()->id();
            @endphp

            @if ($isOwner)
                <div class="bg-[#F7F7F5] border border-[#E9E9E7] rounded-md px-4 py-3 mb-6 text-sm text-[#73726E] flex items-center gap-x-2">
                    <i class="ph ph-info text-[#D9730D]"></i>
                    Kamu tidak bisa mengulas resep milikmu sendiri.
                </div>
            @elseif ($alreadyReviewed)
                <div class="bg-[#F7F7F5] border border-[#E9E9E7] rounded-md px-4 py-3 mb-6 text-sm text-[#73726E] flex items-center gap-x-2">
                    <i class="ph-fill ph-check-circle text-[#0F7B6C]"></i>
                    Kamu sudah memberikan ulasan untuk resep ini.
                </div>
            @else
                <div class="bg-white border border-[#E9E9E7] rounded-md p-4 mb-6">
                    <h3 class="text-sm font-semibold text-[#37352F] mb-3 flex items-center gap-x-2">
                        <i class="ph-bold ph-pencil-simple text-[#D9730D]"></i> Tulis Ulasan
                    </h3>

                    <form method="POST" action="{{ route('recipes.reviews.store', $recipe) }}" class="space-y-3">
                        @csrf

                        {{-- Star rating input --}}
                        <div>
                            <label class="block text-sm font-medium text-[#37352F] mb-1.5">Rating</label>
                            <div class="flex items-center gap-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                            onclick="document.getElementById('recipe-rating-input').value = {{ $i }}; this.parentElement.querySelectorAll('i').forEach((el, idx) => { el.className = idx < {{ $i }} ? 'ph-fill ph-star text-[#EAB308] text-xl cursor-pointer' : 'ph ph-star text-[#E9E9E7] text-xl cursor-pointer'; });"
                                            class="focus:outline-none">
                                        <i class="ph ph-star text-[#E9E9E7] text-xl cursor-pointer"></i>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" id="recipe-rating-input" value="{{ old('rating', 0) }}">
                            </div>
                            @error('rating')
                                <p class="mt-1 text-xs text-[#EB5757]">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Comment --}}
                        <div>
                            <label for="recipe-comment" class="block text-sm font-medium text-[#37352F] mb-1.5">Komentar <span class="text-[#73726E] text-xs">(opsional)</span></label>
                            <textarea id="recipe-comment" name="comment" rows="3"
                                      class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-2 focus:ring-[#2383E2]/20 transition-all"
                                      placeholder="Ceritakan pengalamanmu mencoba resep ini...">{{ old('comment') }}</textarea>
                        </div>

                        <button type="submit"
                                class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                            <i class="ph-bold ph-paper-plane-tilt"></i> Kirim Ulasan
                        </button>
                    </form>
                </div>
            @endif
        @else
            <div class="bg-[#F7F7F5] border border-[#E9E9E7] rounded-md px-4 py-3 mb-6 text-sm text-[#73726E] flex items-center gap-x-2">
                <i class="ph ph-sign-in text-[#2383E2]"></i>
                <a href="{{ route('login') }}" class="text-[#2383E2] hover:underline">Masuk</a> untuk memberikan ulasan.
            </div>
        @endauth

        {{-- Daftar ulasan --}}
        @if ($recipe->reviews->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                <i class="ph-duotone ph-chat-circle-dots text-4xl text-[#E9E9E7] mb-2"></i>
                <p class="italic">Belum ada ulasan untuk resep ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($recipe->reviews as $review)
                    <div class="bg-[#F7F7F5] border border-[#E9E9E7] rounded-md p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-x-2">
                                <span class="grid place-items-center w-7 h-7 rounded-full bg-[#FBE4E4] text-[#BE4D52]">
                                    <i class="ph-fill ph-user text-xs"></i>
                                </span>
                                <span class="text-sm font-medium text-[#37352F]">
                                    {{ $review->user->name ?? 'Anonim' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-x-2">
                                <x-star-rating :rating="$review->rating" />
                                @auth
                                    @if ($review->user_id === auth()->id())
                                        <form method="POST" action="{{ route('recipes.reviews.destroy', [$recipe, $review]) }}"
                                              onsubmit="return confirm('Hapus ulasan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-[#EB5757] hover:bg-red-50 px-1.5 py-0.5 rounded text-xs transition-colors">
                                                <i class="ph ph-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        @if ($review->comment)
                            <p class="text-sm text-[#37352F]/80 leading-relaxed">{{ $review->comment }}</p>
                        @endif
                        <p class="mt-2 text-xs text-[#73726E]">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

@endsection