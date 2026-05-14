@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@php
    $stats = [
        ['label' => 'Total Resep',    'value' => $totalRecipes,     'icon' => 'ph-fill ph-bowl-food',     'bg' => '#FBE4E4', 'fg' => '#BE4D52'],
        ['label' => 'Pending',        'value' => $pendingRecipes,   'icon' => 'ph-fill ph-hourglass-medium', 'bg' => '#FAEBDD', 'fg' => '#D9730D'],
        ['label' => 'Approved',       'value' => $approvedRecipes,  'icon' => 'ph-fill ph-check-circle',  'bg' => '#DDEDEA', 'fg' => '#0F7B6C'],
        ['label' => 'Restoran',       'value' => $totalRestaurants, 'icon' => 'ph-fill ph-storefront',    'bg' => '#DDEBF1', 'fg' => '#2383E2'],
        ['label' => 'Flavor',         'value' => $totalFlavors,     'icon' => 'ph-fill ph-tag',           'bg' => '#F4DFEB', 'fg' => '#C14C8A'],
    ];
@endphp

@section('content')
    <x-page-header title="Dashboard Admin"
                   description="Ringkasan aktivitas Dapurloka."
                   icon="ph-fill ph-shield-check"
                   iconBg="#EAE4F2" iconFg="#6940A5" />

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
        @foreach ($stats as $stat)
            <div class="bg-white border border-[#E9E9E7] rounded-md p-4 hover:bg-[#F7F7F5] transition-colors">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-[#73726E]">{{ $stat['label'] }}</p>
                    <span class="grid place-items-center w-7 h-7 rounded-md"
                          style="background-color: {{ $stat['bg'] }}; color: {{ $stat['fg'] }};">
                        <i class="{{ $stat['icon'] }} text-sm"></i>
                    </span>
                </div>
                <p class="mt-2 text-2xl font-bold" style="color: {{ $stat['fg'] }};">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Recent pending --}}
    <section class="mt-8">
        <div class="flex items-end justify-between mb-3 pb-2 border-b border-[#E9E9E7]">
            <h2 class="text-lg font-semibold text-[#37352F] flex items-center gap-x-2">
                <i class="ph-fill ph-check-square-offset text-[#D9730D]"></i> Antrean Persetujuan Terbaru
            </h2>
            <a href="{{ url('/admin/approvals') }}" class="inline-flex items-center gap-x-1 text-sm text-[#2383E2] hover:underline">
                Lihat semua <i class="ph-bold ph-arrow-right"></i>
            </a>
        </div>

        @if ($recentPending->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                <i class="ph-duotone ph-confetti text-4xl text-[#E9E9E7] mb-2"></i>
                <p class="italic">Tidak ada resep menunggu persetujuan.</p>
            </div>
        @else
            <ul class="divide-y divide-[#E9E9E7] border border-[#E9E9E7] rounded-md overflow-hidden">
                @foreach ($recentPending as $recipe)
                    <li class="px-4 py-3 flex items-center justify-between gap-x-4 hover:bg-[#F7F7F5] transition-colors">
                        <div class="flex items-center gap-x-3 min-w-0">
                            <span class="grid place-items-center w-8 h-8 rounded-md bg-[#FAEBDD] text-[#D9730D] shrink-0">
                                <i class="ph-fill ph-bowl-food"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-[#37352F] truncate">{{ $recipe->title }}</p>
                                <p class="text-xs text-[#73726E] flex items-center gap-x-1">
                                    <i class="ph ph-user"></i> {{ $recipe->user?->name ?? 'Anonim' }}
                                    <span class="text-[#E9E9E7]">&middot;</span>
                                    <i class="ph ph-clock"></i> {{ $recipe->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <x-status-badge :status="$recipe->status" />
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
