@props(['recipe', 'href' => '#'])

@php
    /** @var \App\Models\Recipe $recipe */
    $imageUrl = $recipe->image ? asset('storage/' . $recipe->image) : null;
    $avgRating = $recipe->relationLoaded('reviews')
        ? (float) $recipe->reviews->avg('rating')
        : 0;
    $reviewCount = $recipe->relationLoaded('reviews') ? $recipe->reviews->count() : 0;
@endphp

<a href="{{ $href }}"
   class="group block bg-white border border-[#E9E9E7] rounded-md overflow-hidden hover:bg-[#F7F7F5] hover:border-[#D9730D]/30 transition-colors">

    @if ($imageUrl)
        <div class="aspect-[16/10] bg-[#F7F7F5] overflow-hidden relative">
            <img src="{{ $imageUrl }}" alt="{{ $recipe->title }}" loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-500">
            <div class="absolute top-2 right-2">
                <x-status-badge :status="$recipe->status" />
            </div>
        </div>
    @else
        <div class="aspect-[16/10] bg-gradient-to-br from-[#FAEBDD] to-[#FBE4E4] flex items-center justify-center relative">
            <i class="ph-duotone ph-bowl-food text-4xl text-[#D9730D]/60"></i>
            <div class="absolute top-2 right-2">
                <x-status-badge :status="$recipe->status" />
            </div>
        </div>
    @endif

    <div class="p-4">
        <h3 class="text-sm font-semibold text-[#37352F] line-clamp-1 group-hover:text-[#D9730D] transition-colors">
            {{ $recipe->title }}
        </h3>

        @if ($recipe->relationLoaded('user') && $recipe->user)
            <p class="mt-1 text-xs text-[#73726E] flex items-center gap-x-1">
                <i class="ph ph-user-circle"></i> {{ $recipe->user->name }}
            </p>
        @endif

        @if ($recipe->relationLoaded('flavors') && $recipe->flavors->count())
            <div class="mt-3 flex flex-wrap gap-1">
                @foreach ($recipe->flavors as $flavor)
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
            <i class="ph-bold ph-arrow-right text-[#73726E] group-hover:text-[#D9730D] transition-colors"></i>
        </div>
    </div>
</a>
