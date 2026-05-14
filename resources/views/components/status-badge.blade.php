@props(['status' => 'pending'])

@php
    $map = [
        'approved' => [
            'label'   => 'Approved',
            'classes' => 'bg-[#DDEDEA] text-[#0F7B6C] border-[#0F7B6C]/20',
            'icon'    => 'ph-fill ph-check-circle',
        ],
        'pending'  => [
            'label'   => 'Pending',
            'classes' => 'bg-[#FAEBDD] text-[#D9730D] border-[#D9730D]/20',
            'icon'    => 'ph-fill ph-hourglass-medium',
        ],
        'rejected' => [
            'label'   => 'Rejected',
            'classes' => 'bg-[#FBE4E4] text-[#EB5757] border-[#EB5757]/20',
            'icon'    => 'ph-fill ph-x-circle',
        ],
    ];
    $current = $map[$status] ?? $map['pending'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-x-1 px-2 py-0.5 rounded text-xs font-medium border {$current['classes']}"]) }}>
    <i class="{{ $current['icon'] }}"></i> {{ $current['label'] }}
</span>
