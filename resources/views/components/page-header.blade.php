@props([
    'title',
    'description' => null,
    'icon' => null,           // e.g. 'ph-fill ph-bowl-food'
    'iconBg' => '#F7F7F5',    // accent fill
    'iconFg' => '#37352F',    // accent foreground
])

<div {{ $attributes->merge(['class' => 'flex flex-col sm:flex-row sm:items-end sm:justify-between gap-y-3 mb-6 pb-4 border-b border-[#E9E9E7]']) }}>
    <div class="flex items-start gap-x-3">
        @if ($icon)
            <span class="grid place-items-center w-10 h-10 shrink-0 rounded-md border border-[#E9E9E7]"
                  style="background-color: {{ $iconBg }}; color: {{ $iconFg }};">
                <i class="{{ $icon }} text-lg"></i>
            </span>
        @endif
        <div>
            <h1 class="text-2xl font-bold text-[#37352F] tracking-tight">{{ $title }}</h1>
            @if ($description)
                <p class="mt-1 text-sm text-[#73726E]">{{ $description }}</p>
            @endif
        </div>
    </div>

    @if (trim($slot ?? '') !== '')
        <div class="flex items-center gap-x-2">
            {{ $slot }}
        </div>
    @endif
</div>
