@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <header>
        <h1 class="text-2xl font-bold tracking-tight text-[#37352F]">Buat akun baru</h1>
        <p class="mt-1 text-sm text-[#73726E]">Akun baru otomatis berperan sebagai User.</p>
    </header>

    @if ($errors->any())
        <div class="mt-5 rounded-md border border-[#EB5757]/20 bg-[#FBE4E4] px-3 py-2 text-sm text-[#EB5757]">
            <p class="flex items-center gap-x-1.5 font-medium">
                <i class="ph-fill ph-warning-circle"></i> Periksa kembali isian:
            </p>
            <ul class="mt-1 list-disc list-inside space-y-0.5 pl-1">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ url('/register') }}" class="mt-6 space-y-4" novalidate>
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-[#37352F] mb-1.5">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                   autocomplete="name"
                   class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-2 focus:ring-[#2383E2]/20 transition-all"
                   placeholder="Nama lengkap">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-[#37352F] mb-1.5">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   autocomplete="email"
                   class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-2 focus:ring-[#2383E2]/20 transition-all"
                   placeholder="anda@email.com">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="password" class="block text-sm font-medium text-[#37352F] mb-1.5">Password</label>
                <input type="password" id="password" name="password" required
                       autocomplete="new-password"
                       class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-2 focus:ring-[#2383E2]/20 transition-all"
                       placeholder="Min. 6 karakter">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-[#37352F] mb-1.5">Konfirmasi</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       autocomplete="new-password"
                       class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-2 focus:ring-[#2383E2]/20 transition-all"
                       placeholder="Ulangi password">
            </div>
        </div>

        <button type="submit"
                class="w-full inline-flex items-center justify-center gap-x-2 bg-[#2383E2] text-white px-3 py-2.5 rounded-md text-sm font-medium hover:bg-blue-600 transition-colors">
            Daftar <i class="ph-bold ph-arrow-right"></i>
        </button>

        <p class="text-xs text-[#73726E] text-center leading-relaxed">
            Dengan mendaftar, kamu menyetujui <a href="#" class="text-[#2383E2] hover:underline">Ketentuan</a>
            dan <a href="#" class="text-[#2383E2] hover:underline">Kebijakan Privasi</a> Dapurloka.
        </p>
    </form>

    <div class="my-6 flex items-center gap-x-3">
        <div class="flex-1 h-px bg-[#E9E9E7]"></div>
        <span class="text-xs text-[#73726E] uppercase tracking-wider">Atau</span>
        <div class="flex-1 h-px bg-[#E9E9E7]"></div>
    </div>

    <p class="text-sm text-[#73726E] text-center">
        Sudah punya akun?
        <a href="{{ url('/login') }}" class="text-[#2383E2] font-medium hover:underline">Masuk</a>
    </p>
@endsection
