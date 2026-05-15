<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dapurloka') &mdash; Dapurloka</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#37352F] min-h-screen flex flex-col">
    {{-- Navigation --}}
    <header class="border-b border-[#E9E9E7] bg-white/80 backdrop-blur sticky top-0 z-30">
        <div class="max-w-6xl mx-auto px-4 h-14 flex items-center gap-x-6">
            <a href="{{ url('/') }}" class="flex items-center gap-x-2">
                <span class="grid place-items-center w-7 h-7 rounded-md bg-gradient-to-br from-[#FAEBDD] to-[#FBE4E4] border border-[#E9E9E7]">
                    <i class="ph-fill ph-cooking-pot text-[#D9730D] text-base"></i>
                </span>
                <span class="text-base font-semibold tracking-tight text-[#37352F]">Dapurloka</span>
            </a>

            <nav class="hidden md:flex items-center gap-x-1 text-sm">
                <a href="{{ route('recipes.index') }}"
                   class="inline-flex items-center gap-x-1.5 px-2.5 py-1.5 rounded-lg transition-colors
                          {{ request()->routeIs('recipes.*')
                              ? 'bg-blue-50 text-blue-600'
                              : 'text-[#73726E] hover:bg-[#F7F7F5] hover:text-[#37352F]' }}">
                    <i class="ph ph-bowl-food"></i> Resep
                </a>
                <a href="{{ route('restaurants.index') }}"
                   class="inline-flex items-center gap-x-1.5 px-2.5 py-1.5 rounded-lg transition-colors
                          {{ request()->routeIs('restaurants.*')
                              ? 'bg-blue-50 text-blue-600'
                              : 'text-[#73726E] hover:bg-[#F7F7F5] hover:text-[#37352F]' }}">
                    <i class="ph ph-storefront"></i> Restoran
                </a>
            </nav>

            <div class="ml-auto flex items-center gap-x-2">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center gap-x-1.5 bg-white border border-[#E9E9E7] text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                        <i class="ph-bold ph-squares-four"></i> Dashboard
                    </a>
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-x-1.5 text-[#73726E] hover:text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium transition-colors">
                            <i class="ph ph-sign-out"></i> Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ url('/login') }}"
                       class="text-[#37352F] px-3 py-1.5 rounded-md text-sm font-medium hover:bg-[#F7F7F5] transition-colors">
                        Masuk
                    </a>
                    <a href="{{ url('/register') }}"
                       class="inline-flex items-center gap-x-1.5 bg-[#2383E2] text-white px-3 py-1.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
                        Daftar <i class="ph-bold ph-arrow-right"></i>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Main content --}}
    <main class="flex-1">
        @hasSection('hero')
            @yield('hero')
        @endif

        <div class="max-w-6xl mx-auto px-4 py-8">
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

    {{-- Footer --}}
    <footer class="border-t border-[#E9E9E7] bg-[#F7F7F5]">
        <div class="border-t border-[#E9E9E7]">
            <p class="max-w-6xl mx-auto px-4 py-4 text-xs text-[#73726E]">
                &copy; {{ date('Y') }} Dapurloka. Dibuat untuk UAS Praktikum
        </div>
    </footer>
</body>
</html>
