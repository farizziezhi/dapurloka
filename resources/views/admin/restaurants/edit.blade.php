@extends('layouts.dashboard')

@section('title', 'Edit Restoran')

@section('content')
    <x-page-header title="Edit Restoran"
                   description="Perbarui data restoran."
                   icon="ph-fill ph-storefront" iconBg="#DDEBF1" iconFg="#2383E2" />

    <form method="POST" action="{{ url('/admin/restaurants/' . $restaurant->id) }}" enctype="multipart/form-data" class="max-w-2xl space-y-4">
        @csrf
        @method('PUT')
        @include('admin.restaurants._form', ['restaurant' => $restaurant])

        <div class="flex items-center gap-x-2 pt-2">
            <button type="submit"
                    class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                <i class="ph-bold ph-arrows-clockwise"></i> Perbarui
            </button>
            <a href="{{ url('/admin/restaurants') }}"
               class="inline-flex items-center gap-x-1.5 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                Batal
            </a>
        </div>
    </form>
@endsection
