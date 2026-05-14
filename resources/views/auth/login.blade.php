@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <header>
        <h1 class="text-2xl font-bold tracking-tight text-[#37352F]">Selamat datang kembali</h1>
        <p class="mt-1 text-sm text-[#73726E]">Masuk untuk melanjutkan eksplorasi rasa.</p>
    </header>

    @if ($errors->any())
        <div class="mt-5 flex items-start gap-x-2 rounded-md border border-[#EB5757]/20 bg-[#FBE4E4] px-3 py-2 text-sm text-[#EB5757]">
            <i class="ph-fill ph-warning-circle mt-0.5"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ url('/login') }}" class="mt-6 space-y-4" novalidate>
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-[#37352F] mb-1.5">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   autocomplete="email"
                   class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-2 focus:ring-[#2383E2]/20 transition-all"
                   placeholder="anda@email.com">
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-[#37352F]">Password</label>
                <a href="#" class="text-xs text-[#2383E2] hover:underline">Lupa password?</a>
            </div>
            <input type="password" id="password" name="password" required
                   autocomplete="current-password"
                   class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-2 focus:ring-[#2383E2]/20 transition-all"
                   placeholder="••••••••">
        </div>

        <label class="flex items-center gap-x-2 text-sm text-[#73726E] select-none">
            <input type="checkbox" name="remember" value="1"
                   class="rounded border-[#E9E9E7] text-[#2383E2] focus:ring-[#2383E2]">
            Ingat saya
        </label>

        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-x-2 bg-[#2383E2] text-white px-3 py-2.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
            Masuk <i class="ph-bold ph-arrow-right"></i>
        </button>
    </form>

    <div class="my-6 flex items-center gap-x-3">
        <div class="flex-1 h-px bg-[#E9E9E7]"></div>
        <span class="text-xs text-[#73726E] uppercase tracking-wider">Atau</span>
        <div class="flex-1 h-px bg-[#E9E9E7]"></div>
    </div>

    <p class="text-sm text-[#73726E] text-center">
        Belum punya akun?
        <a href="{{ url('/register') }}" class="text-[#2383E2] font-medium hover:underline">Daftar di sini</a>
    </p>
@endsection
