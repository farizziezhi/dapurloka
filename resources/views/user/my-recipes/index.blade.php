@extends('layouts.dashboard')

@section('title', 'Resep Saya')

@section('content')
    <x-page-header title="Resep Saya"
                   description="Kelola resep yang pernah kamu kirim."
                   icon="ph-fill ph-bowl-food" iconBg="#FAEBDD" iconFg="#D9730D">
        <a href="{{ url('/my/recipes/create') }}"
           class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
            <i class="ph-bold ph-plus-circle"></i> Submit Resep
        </a>
    </x-page-header>

    @if ($recipes->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
            <i class="ph-duotone ph-bowl-food text-4xl text-[#E9E9E7] mb-2"></i>
            <p class="italic">Kamu belum mengirim resep apa pun.</p>
        </div>
    @else
        <div class="overflow-hidden border border-[#E9E9E7] rounded-md">
            <table class="w-full text-sm">
                <thead class="bg-[#F7F7F5] text-[#73726E] text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">Judul</th>
                        <th class="text-left px-4 py-2 font-medium">Flavor</th>
                        <th class="text-left px-4 py-2 font-medium">Status</th>
                        <th class="text-left px-4 py-2 font-medium">Dikirim</th>
                        <th class="text-right px-4 py-2 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E9E9E7] bg-white">
                    @foreach ($recipes as $recipe)
                        <tr class="hover:bg-[#F7F7F5] transition-colors">
                            <td class="px-4 py-2 font-medium text-[#37352F]">{{ $recipe->title }}</td>
                            <td class="px-4 py-2">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($recipe->flavors as $flavor)
                                        <x-flavor-tag :name="$flavor->name" />
                                    @empty
                                        <span class="text-xs text-[#73726E]">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 py-2"><x-status-badge :status="$recipe->status" /></td>
                            <td class="px-4 py-2 text-xs text-[#73726E]">{{ $recipe->created_at->diffForHumans() }}</td>
                            <td class="px-4 py-2 text-right">
                                <div class="inline-flex items-center gap-x-1">
                                    <a href="{{ url('/my/recipes/' . $recipe->id . '/edit') }}"
                                       class="inline-flex items-center gap-x-1 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1 rounded-md text-xs font-medium hover:bg-[#F7F7F5] transition-colors">
                                        <i class="ph ph-pencil-simple"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ url('/my/recipes/' . $recipe->id) }}"
                                          onsubmit="return confirm('Hapus resep ini?');">
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

        <div class="mt-4">{{ $recipes->links() }}</div>
    @endif
@endsection
