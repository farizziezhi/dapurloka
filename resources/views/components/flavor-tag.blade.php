@props(['name', 'href' => null])

@php
    $base = 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#F7F7F5] text-[#73726E] border border-[#E9E9E7]';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $base . ' hover:bg-white hover:text-[#37352F] transition-colors']) }}>
        {{ $name }}
    </a>
@else
    <span {{ $attributes->merge(['class' => $base]) }}>{{ $name }}</span>
@endif
