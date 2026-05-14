@php
    /** @var \App\Models\User|null $authUser */
    $authUser = auth()->user();
    $role = $authUser?->role;

    $pendingCount = ($role === 'admin')
        ? \App\Models\Recipe::where('status', 'pending')->count()
        : 0;

    $roleBadge = $role === 'admin'
        ? ['icon' => 'ph-fill ph-shield-check', 'bg' => '#EAE4F2', 'fg' => '#6940A5', 'label' => 'Admin']
        : ['icon' => 'ph-fill ph-user-circle', 'bg' => '#DDEBF1', 'fg' => '#2383E2', 'label' => 'User'];
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &mdash; Dapurloka</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#37352F] min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 bg-[#F7F7F5] border-r border-[#E9E9E7] flex flex-col">
            <div class="px-4 py-4 border-b border-[#E9E9E7]">
                <a href="{{ url('/') }}" class="flex items-center gap-x-2">
                    <span class="grid place-items-center w-7 h-7 rounded-md bg-gradient-to-br from-[#FAEBDD] to-[#FBE4E4] border border-[#E9E9E7]">
                        <i class="ph-fill ph-cooking-pot text-[#D9730D] text-base"></i>
                    </span>
                    <div>
                        <p class="text-sm font-semibold tracking-tight text-[#37352F] leading-none">Dapurloka</p>
                        <p class="mt-0.5 text-[10px] uppercase tracking-wide text-[#73726E]">Workspace</p>
                    </div>
                </a>
            </div>

            {{-- Profile --}}
            <div class="px-4 py-3 border-b border-[#E9E9E7] flex items-center gap-x-3">
                <span class="grid place-items-center w-9 h-9 rounded-full text-sm font-semibold"
                      style="background-color: {{ $roleBadge['bg'] }}; color: {{ $roleBadge['fg'] }};">
                    {{ strtoupper(mb_substr($authUser?->name ?? '?', 0, 1)) }}
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-[#37352F] truncate">{{ $authUser?->name }}</p>
                    <span class="mt-0.5 inline-flex items-center gap-x-1 px-1.5 py-0.5 rounded text-[10px] font-medium border"
                          style="background-color: {{ $roleBadge['bg'] }}; color: {{ $roleBadge['fg'] }}; border-color: {{ $roleBadge['fg'] }}33;">
                        <i class="{{ $roleBadge['icon'] }}"></i> {{ $roleBadge['label'] }}
                    </span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-2 py-3 space-y-0.5 text-sm overflow-y-auto">
                <a href="{{ url('/dashboard') }}"
                   class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('dashboard') ? 'bg-white shadow-sm' : '' }}">
                    <i class="ph-bold ph-squares-four text-[#73726E]"></i> Dashboard
                </a>

                @can('admin')
                    <p class="px-2 mt-4 mb-1 text-[10px] uppercase tracking-wider text-[#73726E] flex items-center gap-x-1">
                        <i class="ph-bold ph-shield-check"></i> Admin
                    </p>

                    <a href="{{ url('/admin/approvals') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('admin/approvals*') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-check-square-offset text-[#D9730D]"></i>
                        <span class="flex-1">Persetujuan Resep</span>
                        @if ($pendingCount > 0)
                            <span class="inline-flex items-center px-1.5 rounded text-[10px] font-semibold bg-[#FAEBDD] text-[#D9730D] border border-[#D9730D]/20">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ url('/admin/restaurants') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('admin/restaurants*') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-storefront text-[#2383E2]"></i> Kelola Restoran
                    </a>
                    <a href="{{ url('/admin/flavors') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('admin/flavors*') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-tag text-[#C14C8A]"></i> Master Flavor
                    </a>
                    <a href="{{ url('/admin/recipes') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('admin/recipes*') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-bowl-food text-[#0F7B6C]"></i> Daftar Resep
                    </a>
                @endcan

                @can('user')
                    <p class="px-2 mt-4 mb-1 text-[10px] uppercase tracking-wider text-[#73726E] flex items-center gap-x-1">
                        <i class="ph-bold ph-user-circle"></i> Resep Saya
                    </p>

                    <a href="{{ url('/my/recipes/create') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#2383E2] hover:bg-white transition-colors font-medium {{ request()->is('my/recipes/create') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-plus-circle"></i> Submit Resep
                    </a>
                    <a href="{{ url('/my/recipes') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('my/recipes*') && !request()->is('my/recipes/create') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-bowl-food text-[#D9730D]"></i> Resep Saya
                    </a>
                    <a href="{{ url('/my/reviews') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('my/reviews*') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-chat-circle-text text-[#6940A5]"></i> Riwayat Ulasan
                    </a>
                    <a href="{{ url('/my/profile') }}"
                       class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#37352F] hover:bg-white transition-colors {{ request()->is('my/profile*') ? 'bg-white shadow-sm' : '' }}">
                        <i class="ph-bold ph-user-circle text-[#2383E2]"></i> Profil
                    </a>
                @endcan
            </nav>

            {{-- Footer actions --}}
            <div class="px-2 py-3 border-t border-[#E9E9E7] space-y-0.5 text-sm">
                <a href="{{ url('/') }}"
                   class="flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#73726E] hover:bg-white hover:text-[#37352F] transition-colors">
                    <i class="ph ph-house"></i> Kembali ke Beranda
                </a>
                <form method="POST" action="{{ url('/logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-x-2 px-2 py-1.5 rounded-md text-[#73726E] hover:bg-white hover:text-[#EB5757] transition-colors">
                        <i class="ph ph-sign-out"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- Workspace content --}}
        <main class="flex-1 bg-white min-h-screen">
            <div class="max-w-5xl mx-auto px-8 py-8">
                @if (session('status'))
                    <div class="mb-4 inline-flex items-center gap-x-2 rounded-md border border-[#0F7B6C]/20 bg-[#DDEDEA] px-3 py-2 text-sm text-[#0F7B6C]">
                        <i class="ph-fill ph-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 inline-flex items-center gap-x-2 rounded-md border border-[#EB5757]/20 bg-[#FBE4E4] px-3 py-2 text-sm text-[#EB5757]">
                        <i class="ph-fill ph-warning-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
