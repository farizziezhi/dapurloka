<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth') &mdash; Dapurloka</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#37352F] min-h-screen">
    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- Brand panel (hidden on mobile) --}}
        <aside class="hidden lg:flex relative bg-[#F7F7F5] border-r border-[#E9E9E7] flex-col justify-between p-10">
            <div class="absolute inset-0 dapur-grid-bg opacity-50 pointer-events-none"></div>

            <a href="{{ url('/') }}" class="relative inline-flex items-center gap-x-2">
                <span class="grid place-items-center w-9 h-9 rounded-md bg-gradient-to-br from-[#FAEBDD] to-[#FBE4E4] border border-[#E9E9E7]">
                    <i class="ph-fill ph-cooking-pot text-[#D9730D] text-lg"></i>
                </span>
                <span class="text-lg font-bold tracking-tight text-[#37352F]">Dapurloka</span>
            </a>

            <div class="relative max-w-sm">
                <h2 class="text-3xl font-bold tracking-tight leading-tight">
                    Eksplorasi rasa, <span class="dapur-wordmark">temukan dapurmu</span>.
                </h2>
                <p class="mt-3 text-sm text-[#73726E] leading-relaxed">
                    Bergabung dengan komunitas Dapurloka untuk berbagi resep, ulasan, dan menemukan
                    restoran lokal favorit kamu.
                </p>

                <ul class="mt-6 space-y-2.5 text-sm">
                    <li class="flex items-center gap-x-2">
                        <span class="grid place-items-center w-6 h-6 rounded bg-[#DDEDEA] text-[#0F7B6C]">
                            <i class="ph-fill ph-check"></i>
                        </span>
                        Submit resep, dilengkapi review komunitas
                    </li>
                    <li class="flex items-center gap-x-2">
                        <span class="grid place-items-center w-6 h-6 rounded bg-[#DDEBF1] text-[#2383E2]">
                            <i class="ph-fill ph-check"></i>
                        </span>
                        Telusuri restoran lokal pilihan
                    </li>
                    <li class="flex items-center gap-x-2">
                        <span class="grid place-items-center w-6 h-6 rounded bg-[#EAE4F2] text-[#6940A5]">
                            <i class="ph-fill ph-check"></i>
                        </span>
                        Saran AI berdasarkan kondisimu
                    </li>
                </ul>
            </div>

            <p class="relative text-xs text-[#73726E]">&copy; {{ date('Y') }} Dapurloka.</p>
        </aside>

        {{-- Form panel --}}
        <main class="flex flex-col items-center justify-center px-6 py-10 sm:py-16">
            <div class="w-full max-w-sm">
                {{-- Mobile-only brand mark --}}
                <a href="{{ url('/') }}" class="lg:hidden flex items-center justify-center gap-x-2 mb-8">
                    <span class="grid place-items-center w-8 h-8 rounded-md bg-gradient-to-br from-[#FAEBDD] to-[#FBE4E4] border border-[#E9E9E7]">
                        <i class="ph-fill ph-cooking-pot text-[#D9730D]"></i>
                    </span>
                    <span class="text-base font-bold tracking-tight text-[#37352F]">Dapurloka</span>
                </a>

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
