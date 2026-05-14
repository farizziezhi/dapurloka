@extends('layouts.dashboard')

@section('title', 'Riwayat Ulasan')

@section('content')
    <x-page-header title="Riwayat Ulasan"
                   description="Semua ulasan yang pernah kamu berikan."
                   icon="ph-fill ph-chat-circle-text" iconBg="#EAE4F2" iconFg="#6940A5" />

    <section>
        <h2 class="text-base font-semibold text-[#37352F] mb-3 flex items-center gap-x-2">
            <i class="ph-fill ph-bowl-food text-[#D9730D]"></i> Ulasan Resep
        </h2>
        @if ($recipeReviews->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                <i class="ph-duotone ph-chat-circle-text text-4xl text-[#E9E9E7] mb-2"></i>
                <p class="italic">Belum ada ulasan resep.</p>
            </div>
        @else
            <ul class="space-y-2">
                @foreach ($recipeReviews as $review)
                    <li class="bg-white border border-[#E9E9E7] rounded-md p-4">
                        <div class="flex items-start justify-between gap-x-3">
                            <p class="text-sm font-medium text-[#37352F]">{{ $review->recipe?->title ?? 'Resep dihapus' }}</p>
                            <x-star-rating :rating="$review->rating" />
                        </div>
                        @if ($review->comment)
                            <p class="mt-1 text-sm text-[#73726E] whitespace-pre-line">{{ $review->comment }}</p>
                        @endif
                        <p class="mt-1 text-xs text-[#73726E]">{{ $review->created_at->diffForHumans() }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>

    <section class="mt-8">
        <h2 class="text-base font-semibold text-[#37352F] mb-3 flex items-center gap-x-2">
            <i class="ph-fill ph-storefront text-[#2383E2]"></i> Ulasan Restoran
        </h2>
        @if ($restaurantReviews->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                <i class="ph-duotone ph-storefront text-4xl text-[#E9E9E7] mb-2"></i>
                <p class="italic">Belum ada ulasan restoran.</p>
            </div>
        @else
            <ul class="space-y-2">
                @foreach ($restaurantReviews as $review)
                    <li class="bg-white border border-[#E9E9E7] rounded-md p-4">
                        <div class="flex items-start justify-between gap-x-3">
                            <p class="text-sm font-medium text-[#37352F]">{{ $review->restaurant?->name ?? 'Restoran dihapus' }}</p>
                            <x-star-rating :rating="$review->rating" />
                        </div>
                        @if ($review->comment)
                            <p class="mt-1 text-sm text-[#73726E] whitespace-pre-line">{{ $review->comment }}</p>
                        @endif
                        <p class="mt-1 text-xs text-[#73726E]">{{ $review->created_at->diffForHumans() }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
