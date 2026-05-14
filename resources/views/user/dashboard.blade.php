@extends('layouts.dashboard')

@section('title', 'Dashboard')

@php
    $stats = [
        ['label' => 'Total Resep', 'value' => $totalRecipes,    'icon' => 'ph-fill ph-bowl-food',        'bg' => '#FBE4E4', 'fg' => '#BE4D52'],
        ['label' => 'Approved',    'value' => $approvedRecipes, 'icon' => 'ph-fill ph-check-circle',     'bg' => '#DDEDEA', 'fg' => '#0F7B6C'],
        ['label' => 'Pending',     'value' => $pendingRecipes,  'icon' => 'ph-fill ph-hourglass-medium', 'bg' => '#FAEBDD', 'fg' => '#D9730D'],
        ['label' => 'Ulasan',      'value' => $totalRecipeReviews + $totalRestoReviews, 'icon' => 'ph-fill ph-chat-circle-text', 'bg' => '#EAE4F2', 'fg' => '#6940A5'],
    ];
@endphp

@section('content')
    <x-page-header title="Dashboard"
                   description="Ringkasan aktivitas Dapurloka kamu."
                   icon="ph-fill ph-house"
                   iconBg="#DDEBF1" iconFg="#2383E2">
        <a href="{{ url('/my/recipes/create') }}"
           class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
            <i class="ph-bold ph-plus-circle"></i> Submit Resep
        </a>
    </x-page-header>

    {{-- Stats grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
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
                @if ($stat['label'] === 'Ulasan')
                    <p class="mt-1 text-xs text-[#73726E]">{{ $totalRecipeReviews }} resep &middot; {{ $totalRestoReviews }} restoran</p>
                @endif
            </div>
        @endforeach
    </div>

    {{-- Recent recipes --}}
    <section class="mt-8">
        <div class="flex items-end justify-between mb-3 pb-2 border-b border-[#E9E9E7]">
            <h2 class="text-lg font-semibold text-[#37352F] flex items-center gap-x-2">
                <i class="ph-fill ph-bowl-food text-[#D9730D]"></i> Resep Terbaru Kamu
            </h2>
            <a href="{{ url('/my/recipes') }}" class="inline-flex items-center gap-x-1 text-sm text-[#2383E2] hover:underline">
                Kelola semua <i class="ph-bold ph-arrow-right"></i>
            </a>
        </div>

        @if ($recentRecipes->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
                <i class="ph-duotone ph-bowl-food text-4xl text-[#E9E9E7] mb-2"></i>
                <p class="italic">Belum ada resep yang dikirim. Mulai dengan menekan "+ Submit Resep".</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($recentRecipes as $recipe)
                    <x-card-recipe :recipe="$recipe" href="#" />
                @endforeach
            </div>
        @endif
    </section>
@endsection
