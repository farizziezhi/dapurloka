@php
    $restaurant = $restaurant ?? null;
    $selectedFlavors = old('flavors', $restaurant?->flavors->pluck('id')->all() ?? []);
@endphp

@if ($errors->any())
    <div class="rounded-md border border-[#EB5757]/20 bg-[#EB5757]/5 px-3 py-2 text-sm text-[#EB5757]">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="name" class="block text-sm font-medium text-[#37352F] mb-1">Nama Restoran</label>
    <input type="text" id="name" name="name" required
           value="{{ old('name', $restaurant?->name) }}"
           class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-1 focus:ring-[#2383E2] transition-all">
</div>

<div>
    <label for="description" class="block text-sm font-medium text-[#37352F] mb-1">Deskripsi</label>
    <textarea id="description" name="description" rows="4" required
              class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-1 focus:ring-[#2383E2] transition-all">{{ old('description', $restaurant?->description) }}</textarea>
</div>

<div>
    <label for="address" class="block text-sm font-medium text-[#37352F] mb-1">Alamat</label>
    <textarea id="address" name="address" rows="2" required
              class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-1 focus:ring-[#2383E2] transition-all">{{ old('address', $restaurant?->address) }}</textarea>
</div>

<div>
    <label for="phone" class="block text-sm font-medium text-[#37352F] mb-1">Telepon <span class="text-[#73726E] text-xs">(opsional)</span></label>
    <input type="text" id="phone" name="phone"
           value="{{ old('phone', $restaurant?->phone) }}"
           class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-1 focus:ring-[#2383E2] transition-all">
</div>

<div>
    <label for="image" class="block text-sm font-medium text-[#37352F] mb-1">Gambar (RGB) <span class="text-[#73726E] text-xs">(opsional)</span></label>
    @if ($restaurant?->image)
        <img src="{{ asset('storage/' . $restaurant->image) }}" alt="" class="mb-2 w-40 h-24 object-cover rounded-md border border-[#E9E9E7]" loading="lazy">
    @endif
    <input type="file" id="image" name="image" accept="image/*"
           class="w-full text-sm text-[#37352F] file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border file:border-[#E9E9E7] file:bg-white file:text-[#37352F] file:text-sm hover:file:bg-[#F7F7F5]">
    <p class="mt-1 text-xs text-[#73726E]">Format: jpg, jpeg, png, webp. Max 2MB.</p>
</div>

<div>
    <span class="block text-sm font-medium text-[#37352F] mb-1">Flavor</span>
    <div class="flex flex-wrap gap-2">
        @foreach ($flavors as $flavor)
            <label class="inline-flex items-center gap-x-2 px-2.5 py-1 rounded-md border border-[#E9E9E7] bg-white text-xs text-[#37352F] hover:bg-[#F7F7F5] cursor-pointer transition-colors">
                <input type="checkbox" name="flavors[]" value="{{ $flavor->id }}"
                       @checked(in_array($flavor->id, $selectedFlavors))
                       class="rounded border-[#E9E9E7] text-[#2383E2] focus:ring-[#2383E2]">
                {{ $flavor->name }}
            </label>
        @endforeach
    </div>
</div>
