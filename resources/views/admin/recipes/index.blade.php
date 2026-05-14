@extends('layouts.dashboard')

@section('title', 'Daftar Resep')

@section('content')
    <x-page-header title="Daftar Resep"
                   description="Semua resep di sistem."
                   icon="ph-fill ph-bowl-food" iconBg="#DDEDEA" iconFg="#0F7B6C" />

    <div class="flex items-center gap-x-2 mb-4 text-sm">
        @php
            $tabs = [
                ''         => 'Semua',
                'pending'  => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ];
        @endphp
        @foreach ($tabs as $key => $label)
            @php $active = ($status ?? '') === $key; @endphp
            <a href="{{ url('/admin/recipes' . ($key ? '?status=' . $key : '')) }}"
               class="px-3 py-1.5 rounded-md border transition-colors {{ $active ? 'border-[#2383E2] text-[#2383E2] bg-blue-50' : 'border-[#E9E9E7] text-[#73726E] hover:bg-[#F7F7F5]' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if ($recipes->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-[#73726E] text-sm">
            <i class="ph-duotone ph-bowl-food text-4xl text-[#E9E9E7] mb-2"></i>
            <p class="italic">Belum ada resep di kategori ini.</p>
        </div>
    @else
        <div class="overflow-hidden border border-[#E9E9E7] rounded-md">
            <table class="w-full text-sm">
                <thead class="bg-[#F7F7F5] text-[#73726E] text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">Judul</th>
                        <th class="text-left px-4 py-2 font-medium">Pengirim</th>
                        <th class="text-left px-4 py-2 font-medium">Flavor</th>
                        <th class="text-left px-4 py-2 font-medium">Status</th>
                        <th class="text-left px-4 py-2 font-medium">Dikirim</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E9E9E7] bg-white">
                    @foreach ($recipes as $recipe)
                        <tr class="hover:bg-[#F7F7F5] transition-colors">
                            <td class="px-4 py-2 font-medium text-[#37352F]">{{ $recipe->title }}</td>
                            <td class="px-4 py-2 text-[#73726E]">{{ $recipe->user?->name ?? '—' }}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $recipes->links() }}</div>
    @endif
@endsection
