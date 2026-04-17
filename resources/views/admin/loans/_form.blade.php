@php
    $selectedReturnDate = old('expected_return_date', isset($loan) && $loan->expected_return_date ? $loan->expected_return_date->format('Y-m-d') : '');
    $selectedReturnTime = old(
        'expected_return_time',
        isset($loan) && $loan->expected_return_time ? \Illuminate\Support\Carbon::parse($loan->expected_return_time)->format('H:i') : ''
    );
@endphp

@csrf
<div class="grid gap-5">
    <div>
        <label for="user_id" class="mb-2 block text-sm font-medium text-slate-200">Peminjam</label>
        <select id="user_id" name="user_id" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
            <option value="">Pilih User</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $loan?->user_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="book_id" class="mb-2 block text-sm font-medium text-slate-200">Buku</label>
        <select id="book_id" name="book_id" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
            <option value="">Pilih Buku</option>
            @foreach($books as $book)
                <option value="{{ $book->id }}" {{ old('book_id', $loan?->book_id ?? '') == $book->id ? 'selected' : '' }}>
                    {{ $book->judul }} - {{ $book->penulis }} (Stok: {{ $book->stok }})
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="status" class="mb-2 block text-sm font-medium text-slate-200">Status</label>
        <select id="status" name="status" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
            <option value="">Pilih Status</option>
            <option value="pending" {{ old('status', $loan?->status ?? '') == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
            <option value="pinjam" {{ old('status', $loan?->status ?? '') == 'pinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="rejected" {{ old('status', $loan?->status ?? '') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            <option value="kembali" {{ old('status', $loan?->status ?? '') == 'kembali' ? 'selected' : '' }}>Dikembalikan</option>
        </select>
        <p class="mt-2 text-xs text-slate-400">Gunakan status <span class="text-slate-200">pending</span> untuk pengajuan baru, atau <span class="text-slate-200">pinjam</span> untuk langsung mengaktifkan peminjaman.</p>
    </div>
    <div>
        <label for="expected_return_date" class="mb-2 block text-sm font-medium text-slate-200">Tanggal Kembali (Expected)</label>
        <input id="expected_return_date" name="expected_return_date" type="date" value="{{ $selectedReturnDate }}" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
    </div>
    <div>
        <label for="expected_return_time" class="mb-2 block text-sm font-medium text-slate-200">Waktu Kembali (Expected)</label>
        <input id="expected_return_time" name="expected_return_time" type="time" value="{{ $selectedReturnTime }}" required
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400">
    </div>

    <div>
        <label for="alamat" class="mb-2 block text-sm font-medium text-slate-200">Alamat (Opsional)</label>
        <textarea id="alamat" name="alamat" rows="2" 
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400 resize-vertical"
            placeholder="Alamat peminjam...">{{ old('alamat', $loan->alamat ?? '') }}</textarea>
    </div>

    <div>
        <label for="nomor_hp" class="mb-2 block text-sm font-medium text-slate-200">Nomor HP (Opsional)</label>
        <input id="nomor_hp" type="tel" name="nomor_hp" 
            class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 outline-none transition focus:border-sky-400"
            value="{{ old('nomor_hp', $loan->nomor_hp ?? '') }}" placeholder="08123456789">
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="rounded-2xl bg-sky-500 px-6 py-3 font-semibold text-white transition hover:bg-sky-400 flex-1">
            Simpan
        </button>
        <a href="{{ route('admin.loans.index') }}" class="rounded-2xl border border-white/10 px-6 py-3 font-semibold text-slate-200 transition hover:bg-white/5 flex-1 text-center">
            Batal
        </a>
    </div>
</div>

