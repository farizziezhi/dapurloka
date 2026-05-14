@extends('layouts.dashboard')

@section('title', 'Edit Resep')

@section('content')
    <x-page-header title="Edit Resep"
                   description="Perbarui detail resep kamu."
                   icon="ph-fill ph-pencil-simple" iconBg="#FAEBDD" iconFg="#D9730D" />

    <form method="POST" action="{{ url('/my/recipes/' . $recipe->id) }}" enctype="multipart/form-data" class="max-w-2xl space-y-4">
        @csrf
        @method('PUT')
        @include('user.my-recipes._form', ['recipe' => $recipe])

        <div class="flex items-center gap-x-2 pt-2">
            <button type="submit"
                    class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                <i class="ph-bold ph-arrows-clockwise"></i> Perbarui
            </button>
            <a href="{{ url('/my/recipes') }}"
               class="inline-flex items-center gap-x-1.5 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                Batal
            </a>
        </div>
    </form>
@endsection
