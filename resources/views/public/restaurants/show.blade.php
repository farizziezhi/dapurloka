@extends('layouts.main')

@section('title', $restaurant->name)

@section('content')

    {{-- Tombol kembali --}}
    <div class="mb-6">
        <a href="{{ route('restaurants.index') }}"
           class="inline-flex items-center gap-x-1.5 text-sm text-[#73726E] hover:text-[#37352F] transition-colors">
            <i class="ph-bold ph-arrow-left relative top-[2px]"></i> Kembali ke daftar
        </a>
    </div>

    {{-- Hero image --}}
    @php
        $imageUrl = $restaurant->image ? asset('storage/' . $restaurant->image) : null;
    @endphp

    @if ($imageUrl)
        <div class="aspect-[21/9] rounded-lg overflow-hidden bg-[#F7F7F5] border border-[#E9E9E7] mb-8">
            <img src="{{ $imageUrl }}" alt="{{ $restaurant->name }}" loading="lazy"
                 class="w-full h-full object-cover">
        </div>
    @else
        <div class="aspect-[21/9] rounded-lg overflow-hidden bg-gradient-to-br from-[#DDEBF1] to-[#EAE4F2] border border-[#E9E9E7] mb-8 flex items-center justify-center">
            <i class="ph-duotone ph-storefront text-6xl text-[#2383E2]/40"></i>
        </div>
    @endif

    {{-- Info utama --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Kolom kiri: nama, deskripsi, flavors --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Nama & rating --}}
            <div>
                <h1 class="text-2xl font-bold text-[#37352F] tracking-tight">{{ $restaurant->name }}</h1>

                <div class="mt-2 flex items-center gap-x-3">
                    @if ($restaurant->reviews->count() > 0)
                        <x-star-rating :rating="$avgRating" :showValue="true" />
                        <span class="text-xs text-[#73726E]">{{ $restaurant->reviews->count() }} ulasan</span>
                    @else
                        <span class="text-xs text-[#73726E] italic">Belum ada ulasan</span>
                    @endif
                </div>
            </div>

            {{-- Flavor tags --}}
            @if ($restaurant->flavors->count())
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($restaurant->flavors as $flavor)
                        <x-flavor-tag :name="$flavor->name" />
                    @endforeach
                </div>
            @endif

            {{-- Deskripsi --}}
            @if ($restaurant->description)
                <div class="prose prose-sm max-w-none text-[#37352F]">
                    <p class="text-sm leading-relaxed text-[#37352F]/90">{{ $restaurant->description }}</p>
                </div>
            @endif

            {{-- Daftar review --}}
            <section class="pt-6 border-t border-[#E9E9E7]">
                <h2 class="text-lg font-semibold text-[#37352F] flex items-center gap-x-2 mb-4">
                    <i class="ph-fill ph-chat-circle-dots text-[#2383E2]"></i>
                    Ulasan ({{ $restaurant->reviews->count() }})
                </h2>

                @if ($restaurant->reviews->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                        <i class="ph-duotone ph-chat-circle-dots text-4xl text-[#E9E9E7] mb-2"></i>
                        <p class="italic">Belum ada ulasan untuk restaurant ini.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($restaurant->reviews as $review)
                            <div class="bg-[#F7F7F5] border border-[#E9E9E7] rounded-md p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-x-2">
                                        <span class="grid place-items-center w-7 h-7 rounded-full bg-[#DDEBF1] text-[#2383E2]">
                                            <i class="ph-fill ph-user text-xs"></i>
                                        </span>
                                        <span class="text-sm font-medium text-[#37352F]">
                                            {{ $review->user->name ?? 'Anonim' }}
                                        </span>
                                    </div>
                                    <x-star-rating :rating="$review->rating" />
                                </div>
                                @if ($review->comment)
                                    <p class="text-sm text-[#37352F]/80 leading-relaxed">{{ $review->comment }}</p>
                                @endif
                                <p class="mt-2 text-xs text-[#73726E]">
                                    {{ $review->created_at->diffForHumans() }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        {{-- Kolom kanan: sidebar info kontak --}}
        <div class="space-y-4">
            <div class="bg-[#F7F7F5] border border-[#E9E9E7] rounded-md p-5 space-y-4">
                <h3 class="text-sm font-semibold text-[#37352F] flex items-center gap-x-2">
                    <i class="ph-fill ph-info text-[#2383E2]"></i> Informasi
                </h3>

                {{-- Alamat --}}
                @if ($restaurant->address)
                    <div class="flex items-start gap-x-2.5">
                        <i class="ph ph-map-pin text-[#73726E] mt-0.5 shrink-0"></i>
                        <div>
                            <p class="text-xs font-medium text-[#73726E] uppercase tracking-wider">Alamat</p>
                            <p class="text-sm text-[#37352F] mt-0.5">{{ $restaurant->address }}</p>
                        </div>
                    </div>
                @endif

                {{-- Telepon --}}
                @if ($restaurant->phone)
                    <div class="flex items-start gap-x-2.5">
                        <i class="ph ph-phone text-[#73726E] mt-0.5 shrink-0"></i>
                        <div>
                            <p class="text-xs font-medium text-[#73726E] uppercase tracking-wider">Telepon</p>
                            <p class="text-sm text-[#37352F] mt-0.5">{{ $restaurant->phone }}</p>
                        </div>
                    </div>
                @endif

                {{-- Rating summary --}}
                <div class="flex items-start gap-x-2.5">
                    <i class="ph ph-star text-[#73726E] mt-0.5 shrink-0"></i>
                    <div>
                        <p class="text-xs font-medium text-[#73726E] uppercase tracking-wider">Rating</p>
                        @if ($restaurant->reviews->count() > 0)
                            <p class="text-sm text-[#37352F] mt-0.5 font-semibold">
                                {{ number_format($avgRating, 1) }} / 5
                                <span class="font-normal text-[#73726E]">({{ $restaurant->reviews->count() }} ulasan)</span>
                            </p>
                        @else
                            <p class="text-sm text-[#73726E] mt-0.5 italic">Belum ada ulasan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
