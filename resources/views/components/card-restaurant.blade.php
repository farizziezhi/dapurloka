@props(['restaurant', 'href' => '#'])

@php
    /** @var \App\Models\Restaurant $restaurant */
    $imageUrl = $restaurant->image ? asset('storage/' . $restaurant->image) : null;
    $avgRating = $restaurant->relationLoaded('reviews')
        ? (float) $restaurant->reviews->avg('rating')
        : 0;
    $reviewCount = $restaurant->relationLoaded('reviews') ? $restaurant->reviews->count() : 0;
@endphp

<a href="{{ $href }}"
   class="group block bg-white border border-[#E9E9E7] rounded-md overflow-hidden hover:bg-[#F7F7F5] hover:border-[#2383E2]/30 transition-colors">

    @if ($imageUrl)
        <div class="aspect-[16/10] bg-[#F7F7F5] overflow-hidden">
            <img src="{{ $imageUrl }}" alt="{{ $restaurant->name }}" loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-500">
        </div>
    @else
        <div class="aspect-[16/10] bg-gradient-to-br from-[#DDEBF1] to-[#EAE4F2] flex items-center justify-center">
            <i class="ph-duotone ph-storefront text-4xl text-[#2383E2]/60"></i>
        </div>
    @endif

    <div class="p-4">
        <h3 class="text-sm font-semibold text-[#37352F] line-clamp-1 group-hover:text-[#2383E2] transition-colors">
            {{ $restaurant->name }}
        </h3>
        <p class="mt-1 text-xs text-[#73726E] line-clamp-2 flex items-start gap-x-1">
            <i class="ph ph-map-pin mt-0.5 shrink-0"></i>
            <span>{{ $restaurant->address }}</span>
        </p>

        @if ($restaurant->relationLoaded('flavors') && $restaurant->flavors->count())
            <div class="mt-3 flex flex-wrap gap-1">
                @foreach ($restaurant->flavors as $flavor)
                    <x-flavor-tag :name="$flavor->name" />
                @endforeach
            </div>
        @endif

        <div class="mt-3 flex items-center justify-between">
            @if ($reviewCount > 0)
                <div class="flex items-center gap-x-2">
                    <x-star-rating :rating="$avgRating" />
                    <span class="text-xs text-[#73726E]">{{ $reviewCount }} ulasan</span>
                </div>
            @else
                <span class="text-xs text-[#73726E] italic">Belum ada ulasan</span>
            @endif
            <i class="ph-bold ph-arrow-right text-[#73726E] group-hover:text-[#2383E2] transition-colors"></i>
        </div>
    </div>
</a>
