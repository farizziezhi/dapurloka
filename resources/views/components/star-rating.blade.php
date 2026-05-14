@props(['rating' => 0, 'max' => 5, 'showValue' => false])

@php
    $rating = max(0, min((float) $rating, (int) $max));
    $rounded = (int) round($rating);
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-0.5']) }}>
    @for ($i = 1; $i <= $max; $i++)
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
             class="w-4 h-4 fill-current {{ $i <= $rounded ? 'text-[#EAB308]' : 'text-[#E9E9E7]' }}">
            <path d="M10 1.5l2.7 5.46 6.03.88-4.36 4.25 1.03 6L10 15.27l-5.4 2.84 1.03-6L1.27 7.84l6.03-.88L10 1.5z"/>
        </svg>
    @endfor

    @if ($showValue)
        <span class="ml-1 text-xs text-[#73726E]">{{ number_format($rating, 1) }}</span>
    @endif
</div>
