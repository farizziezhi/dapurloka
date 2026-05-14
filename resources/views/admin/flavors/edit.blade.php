@extends('layouts.dashboard')

@section('title', 'Edit Flavor')

@section('content')
    <x-page-header title="Edit Flavor"
                   description="Perbarui kategori rasa."
                   icon="ph-fill ph-tag" iconBg="#F4DFEB" iconFg="#C14C8A" />

    <form method="POST" action="{{ url('/admin/flavors/' . $flavor->id) }}" class="max-w-xl space-y-4">
        @csrf
        @method('PUT')
        @include('admin.flavors._form', ['flavor' => $flavor])

        <div class="flex items-center gap-x-2 pt-2">
            <button type="submit"
                    class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                <i class="ph-bold ph-arrows-clockwise"></i> Perbarui
            </button>
            <a href="{{ url('/admin/flavors') }}"
               class="inline-flex items-center gap-x-1.5 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                Batal
            </a>
        </div>
    </form>
@endsection
