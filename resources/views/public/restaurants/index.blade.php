@extends('layouts.main')

@section('title', 'Semua Restaurant')

@section('content')

    {{-- Header halaman — pakai komponen page-header yang sudah ada --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#37352F] flex items-center gap-x-2">
            <i class="ph-fill ph-storefront text-[#2383E2]"></i> Restaurant        
        </h1>
        <p class="mt-1 text-sm text-[#73726E]">Temukan restaurant terbaik dari komunitas.</p>
    </div>

    {{-- Hasil restoran --}}
    @if ($restaurants->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-[#73726E] text-sm">
            <i class="ph-duotone ph-storefront text-5xl text-[#E9E9E7] mb-3"></i>
            <p class="italic">Belum ada restaurant.</p>
        </div>
    @else
        {{-- Grid kartu restoran, pakai komponen card-restaurant yang sudah ada --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($restaurants as $restaurant)
                <x-card-restaurant
                    :restaurant="$restaurant"
                    :href="route('restaurants.show', $restaurant)" />
            @endforeach
        </div>

        <div class="mt-6">
            {{ $restaurants->links() }}
        </div>
    @endif

@endsection
