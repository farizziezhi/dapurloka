@extends('layouts.dashboard')

@section('title', 'Kelola Flavor')

@section('content')
    <x-page-header title="Master Flavor"
                   description="Kategori rasa untuk resep dan restoran."
                   icon="ph-fill ph-tag" iconBg="#F4DFEB" iconFg="#C14C8A">
        <a href="{{ url('/admin/flavors/create') }}"
           class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
            <i class="ph-bold ph-plus-circle"></i> Tambah Flavor
        </a>
    </x-page-header>

    @if ($flavors->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
            <i class="ph-duotone ph-tag text-4xl text-[#E9E9E7] mb-2"></i>
            <p class="italic">Belum ada flavor terdaftar.</p>
        </div>
    @else
        <div class="overflow-hidden border border-[#E9E9E7] rounded-md">
            <table class="w-full text-sm">
                <thead class="bg-[#F7F7F5] text-[#73726E] text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">Nama</th>
                        <th class="text-left px-4 py-2 font-medium">Deskripsi</th>
                        <th class="text-left px-4 py-2 font-medium">Resep</th>
                        <th class="text-left px-4 py-2 font-medium">Restoran</th>
                        <th class="text-right px-4 py-2 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E9E9E7] bg-white">
                    @foreach ($flavors as $flavor)
                        <tr class="hover:bg-[#F7F7F5] transition-colors">
                            <td class="px-4 py-2 font-medium text-[#37352F]">{{ $flavor->name }}</td>
                            <td class="px-4 py-2 text-[#73726E]">{{ $flavor->description ?? '—' }}</td>
                            <td class="px-4 py-2 text-[#73726E]">{{ $flavor->recipes_count }}</td>
                            <td class="px-4 py-2 text-[#73726E]">{{ $flavor->restaurants_count }}</td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-x-1">
                                    <a href="{{ url('/admin/flavors/' . $flavor->id . '/edit') }}"
                                       class="inline-flex items-center gap-x-1 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1 rounded-md text-xs font-medium hover:bg-[#F7F7F5] transition-colors">
                                        <i class="ph ph-pencil-simple"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ url('/admin/flavors/' . $flavor->id) }}"
                                          onsubmit="return confirm('Hapus flavor ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center gap-x-1 text-[#EB5757] hover:bg-red-50 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                            <i class="ph ph-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $flavors->links() }}</div>
    @endif
@endsection
