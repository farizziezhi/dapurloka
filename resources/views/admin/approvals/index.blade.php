@extends('layouts.dashboard')

@section('title', 'Persetujuan Resep')

@section('content')
    <x-page-header title="Persetujuan Resep"
                   description="Tinjau resep dari komunitas sebelum tayang."
                   icon="ph-fill ph-check-square-offset" iconBg="#FAEBDD" iconFg="#D9730D" />

    @if ($recipes->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
            <i class="ph-duotone ph-confetti text-4xl text-[#E9E9E7] mb-2"></i>
            <p class="italic">Tidak ada resep menunggu persetujuan.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($recipes as $recipe)
                <article class="bg-white border border-[#E9E9E7] rounded-md p-4">
                    <div class="flex items-start gap-x-4">
                        @if ($recipe->image)
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}"
                                 loading="lazy" class="w-24 h-24 object-cover rounded-md border border-[#E9E9E7]">
                        @else
                            <div class="w-24 h-24 bg-[#F7F7F5] rounded-md border border-[#E9E9E7] flex items-center justify-center text-xs text-[#73726E]">
                                Tanpa gambar
                            </div>
                        @endif

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-x-3">
                                <h3 class="text-sm font-semibold text-[#37352F]">{{ $recipe->title }}</h3>
                                <x-status-badge :status="$recipe->status" />
                            </div>
                            <p class="mt-1 text-xs text-[#73726E]">
                                oleh {{ $recipe->user?->name ?? 'Anonim' }} &middot; {{ $recipe->created_at->diffForHumans() }}
                            </p>

                            @if ($recipe->flavors->count())
                                <div class="mt-2 flex flex-wrap gap-1">
                                    @foreach ($recipe->flavors as $flavor)
                                        <x-flavor-tag :name="$flavor->name" />
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3 text-xs text-[#37352F]">
                                <div class="bg-[#F7F7F5] rounded-md p-3">
                                    <p class="text-[#73726E] uppercase tracking-wide mb-1">Bahan</p>
                                    <p class="whitespace-pre-line line-clamp-4">{{ $recipe->ingredients }}</p>
                                </div>
                                <div class="bg-[#F7F7F5] rounded-md p-3">
                                    <p class="text-[#73726E] uppercase tracking-wide mb-1">Langkah</p>
                                    <p class="whitespace-pre-line line-clamp-4">{{ $recipe->steps }}</p>
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-x-2">
                                <form method="POST" action="{{ url('/admin/recipes/' . $recipe->id . '/approve') }}">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-x-1.5 bg-[#0F7B6C] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#0d6b5d] transition-colors">
                                        <i class="ph-bold ph-check"></i> Setujui
                                    </button>
                                </form>
                                <form method="POST" action="{{ url('/admin/recipes/' . $recipe->id . '/reject') }}">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center gap-x-1.5 text-[#EB5757] hover:bg-red-50 px-3 py-1.5 rounded-md text-sm font-medium transition-colors">
                                        <i class="ph-bold ph-x"></i> Tolak
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4">{{ $recipes->links() }}</div>
    @endif
@endsection
