@extends('layouts.dashboard')

@section('title', 'Kelola Restoran')

@section('content')
    <x-page-header title="Kelola Restoran"
                   description="Daftar restoran yang tampil di Dapurloka."
                   icon="ph-fill ph-storefront" iconBg="#DDEBF1" iconFg="#2383E2">
        <a href="{{ url('/admin/restaurants/create') }}"
           class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
            <i class="ph-bold ph-plus-circle"></i> Tambah Restoran
        </a>
    </x-page-header>

    @if ($restaurants->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
            <i class="ph-duotone ph-storefront text-4xl text-[#E9E9E7] mb-2"></i>
            <p class="italic">Belum ada restoran terdaftar.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($restaurants as $restaurant)
                <div class="bg-white border border-[#E9E9E7] rounded-md overflow-hidden">
                    @if ($restaurant->image)
                        <div class="aspect-[16/10] bg-[#F7F7F5]">
                            <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}"
                                 loading="lazy" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-[16/10] bg-[#F7F7F5] flex items-center justify-center text-[#73726E] text-xs">
                            Tanpa gambar
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-[#37352F]">{{ $restaurant->name }}</h3>
                        <p class="mt-1 text-xs text-[#73726E] line-clamp-2">{{ $restaurant->address }}</p>

                        @if ($restaurant->flavors->count())
                            <div class="mt-3 flex flex-wrap gap-1">
                                @foreach ($restaurant->flavors as $flavor)
                                    <x-flavor-tag :name="$flavor->name" />
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-4 flex items-center gap-x-1">
                            <a href="{{ url('/admin/restaurants/' . $restaurant->id . '/edit') }}"
                               class="inline-flex items-center gap-x-1 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1 rounded-md text-xs font-medium hover:bg-[#F7F7F5] transition-colors">
                                <i class="ph ph-pencil-simple"></i> Edit
                            </a>
                            <form method="POST" action="{{ url('/admin/restaurants/' . $restaurant->id) }}"
                                  onsubmit="return confirm('Hapus restoran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-x-1 text-[#EB5757] hover:bg-red-50 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                    <i class="ph ph-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $restaurants->links() }}</div>
    @endif
@endsection
