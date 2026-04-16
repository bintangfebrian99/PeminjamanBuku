@csrf
<div class="grid gap-5">
    <div>
        <label for="judul" class="mb-2 block text-sm font-medium text-slate-200">Judul</label>
        <input id="judul" name="judul" type="text" value="{{ old('judul', $book?->judul ?? '') }}" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
    </div>
    <div>
        <label for="penulis" class="mb-2 block text-sm font-medium text-slate-200">Penulis</label>
        <input id="penulis" name="penulis" type="text" value="{{ old('penulis', $book?->penulis ?? '') }}" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
    </div>
    <div>
        <label for="penerbit" class="mb-2 block text-sm font-medium text-slate-200">Penerbit</label>
        <input id="penerbit" name="penerbit" type="text" value="{{ old('penerbit', $book?->penerbit ?? '') }}"
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
    </div>
    <div>
        <label for="tahun_penerbit" class="mb-2 block text-sm font-medium text-slate-200">Tahun Penerbit</label>
        <input id="tahun_penerbit" name="tahun_penerbit" type="number" min="1900" max="{{ date('Y')+1 }}" value="{{ old('tahun_penerbit', $book?->tahun_penerbit ?? '') }}"
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
    </div>
    <div>
        <label for="deskripsi" class="mb-2 block text-sm font-medium text-slate-200">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="5"
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">{{ old('deskripsi', $book?->deskripsi ?? '') }}</textarea>
    </div>
    <div>
        <label for="stok" class="mb-2 block text-sm font-medium text-slate-200">Stok</label>
        <input id="stok" name="stok" type="number" min="0" value="{{ old('stok', $book?->stok ?? 0) }}" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
    </div>
    <div>
        <label for="cover_image" class="mb-2 block text-sm font-medium text-slate-200">Cover Image</label>
        <input id="cover_image" name="cover_image" type="file" accept="image/*"
            class="w-full rounded-2xl border border-dashed border-white/10 bg-slate-950 px-4 py-3 text-slate-300 file:mr-4 file:rounded-xl file:border-0 file:bg-sky-500 file:px-4 file:py-2 file:font-semibold file:text-white">
        @if (!empty($book?->cover_image))
            <div class="mt-3 flex items-start gap-4 rounded-2xl border border-white/10 bg-slate-950/70 p-4">
                <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}" class="h-24 w-20 rounded-xl object-cover">
                <div>
                    <p class="text-sm font-medium text-white">Cover saat ini</p>
                    <p class="mt-1 text-xs text-slate-400">Upload file baru jika ingin mengganti gambar buku ini.</p>
                </div>
            </div>
        @endif
        @error('cover_image')
            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex items-center gap-3">
        <button class="rounded-2xl bg-sky-500 px-4 py-3 font-semibold text-white transition hover:bg-sky-400">
            Simpan
        </button>
        <a href="{{ route('admin.books.index') }}" class="rounded-2xl border border-white/10 px-4 py-3 font-semibold text-slate-200 transition hover:bg-white/5">
            Batal
        </a>
    </div>
</div>
