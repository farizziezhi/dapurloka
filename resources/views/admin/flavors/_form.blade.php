@php $flavor = $flavor ?? null; @endphp

@if ($errors->any())
    <div class="rounded-md border border-[#EB5757]/20 bg-[#EB5757]/5 px-3 py-2 text-sm text-[#EB5757]">
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="name" class="block text-sm font-medium text-[#37352F] mb-1">Nama</label>
    <input type="text" id="name" name="name" required
           value="{{ old('name', $flavor?->name) }}"
           class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-1 focus:ring-[#2383E2] transition-all"
           placeholder="Pedas, Manis, dll.">
</div>

<div>
    <label for="description" class="block text-sm font-medium text-[#37352F] mb-1">Deskripsi <span class="text-[#73726E] text-xs">(opsional)</span></label>
    <textarea id="description" name="description" rows="3"
              class="w-full border border-[#E9E9E7] rounded-md px-3 py-2 text-sm text-[#37352F] placeholder-[#73726E] focus:outline-none focus:border-[#2383E2] focus:ring-1 focus:ring-[#2383E2] transition-all"
              placeholder="Deskripsi singkat...">{{ old('description', $flavor?->description) }}</textarea>
</div>
