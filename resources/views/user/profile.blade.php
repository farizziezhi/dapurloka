@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')
    <x-page-header title="Profil Saya"
                   description="Perbarui nama dan password akun kamu."
                   icon="ph-fill ph-user-circle"
                   iconBg="#DDEBF1" iconFg="#2383E2" />

    <form method="POST" action="{{ route('my.profile.update') }}" class="mt-6 max-w-lg space-y-5">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-[#37352F] mb-1">Nama</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', auth()->user()->name) }}"
                   class="w-full rounded-md border border-[#E9E9E7] bg-white px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:ring-1 focus:ring-[#2383E2] focus:border-[#2383E2]"
                   required>
            @error('name')
                <p class="mt-1 text-xs text-[#EB5757]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email (read-only) --}}
        <div>
            <label class="block text-sm font-medium text-[#37352F] mb-1">Email</label>
            <input type="email" value="{{ auth()->user()->email }}" disabled
                   class="w-full rounded-md border border-[#E9E9E7] bg-[#F7F7F5] px-3 py-2 text-sm text-[#73726E] cursor-not-allowed">
            <p class="mt-1 text-xs text-[#73726E] italic">Email tidak dapat diubah.</p>
        </div>

        <hr class="border-[#E9E9E7]">

        {{-- Password baru --}}
        <div>
            <label for="password" class="block text-sm font-medium text-[#37352F] mb-1">Password Baru</label>
            <input id="password" name="password" type="password"
                   placeholder="Kosongkan jika tidak ingin mengubah"
                   class="w-full rounded-md border border-[#E9E9E7] bg-white px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:ring-1 focus:ring-[#2383E2] focus:border-[#2383E2]">
            @error('password')
                <p class="mt-1 text-xs text-[#EB5757]">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-[#37352F] mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   placeholder="Ulangi password baru"
                   class="w-full rounded-md border border-[#E9E9E7] bg-white px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:ring-1 focus:ring-[#2383E2] focus:border-[#2383E2]">
        </div>

        <div>
            <button type="submit"
                    class="inline-flex items-center gap-x-1.5 rounded-md bg-[#2383E2] px-4 py-2 text-sm font-medium text-white hover:bg-[#1a6fc4] transition-colors">
                <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>
    </form>
@endsection
