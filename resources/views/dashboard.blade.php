<x-layouts.app title="Dashboard" heading="Dashboard">
    <section class="mb-8 overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 via-slate-900 to-sky-950/70 shadow-2xl shadow-slate-950/30">
        <div class="grid gap-6 p-6 lg:grid-cols-[1.2fr_0.8fr] lg:p-8">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-sky-300">Halo, {{ $userName }}</p>
                <h2 class="mt-3 max-w-2xl text-3xl font-semibold text-white sm:text-4xl">
                    {{ $isAdmin ? 'Kelola perpustakaan dari satu tempat.' : 'Temukan buku dan pinjam dengan cepat.' }}
                </h2>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-slate-300 sm:text-base">
                    {{ $isAdmin ? 'Pantau stok, lihat statistik peminjaman, dan kelola koleksi buku dengan alur yang sederhana.' : 'Lihat katalog buku terbaru, cek stok tersedia, dan pantau buku yang sedang kamu pinjam.' }}
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($isAdmin)
                        <a href="{{ route('admin.books.index') }}" class="rounded-2xl bg-sky-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-sky-400">
                            Kelola Buku
                        </a>
                        <a href="{{ route('admin.loans.index') }}" class="rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400">
                            Kelola Peminjaman
                        </a>
                    @else
                        <a href="{{ route('books.index') }}" class="rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400">
                            Lihat Katalog
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/5">
                        Refresh Data
                    </a>
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-sm text-slate-400">Total buku</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $stats['books'] }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-sm text-slate-400">Buku tersedia</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $stats['available_books'] }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-sm text-slate-400">Peminjaman aktif</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $stats['active_loans'] }}</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                    <p class="text-sm text-slate-400">Peminjaman kembali</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ $stats['returned_loans'] }}</p>
                </div>
                @if ($isAdmin)
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 sm:col-span-2">
                        <p class="text-sm text-slate-400">Total user</p>
                        <p class="mt-2 text-3xl font-semibold text-white">{{ $stats['users'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="mb-8 grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-lg shadow-slate-950/30">
            <p class="text-sm text-slate-400">Akses cepat</p>
            <p class="mt-2 text-xl font-semibold text-white">{{ $isAdmin ? 'Admin panel' : 'User dashboard' }}</p>
            <p class="mt-2 text-sm text-slate-400">{{ $isAdmin ? 'Bisa tambah, edit, dan hapus buku.' : 'Bisa pinjam dan kembalikan buku.' }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-lg shadow-slate-950/30">
            <p class="text-sm text-slate-400">Status koleksi</p>
            <p class="mt-2 text-xl font-semibold text-white">{{ $stats['available_books'] > 0 ? 'Masih tersedia' : 'Perlu restock' }}</p>
            <p class="mt-2 text-sm text-slate-400">Pantau stok sebelum user melakukan peminjaman.</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-lg shadow-slate-950/30">
            <p class="text-sm text-slate-400">Aktivitas terakhir</p>
            <p class="mt-2 text-xl font-semibold text-white">{{ $isAdmin ? 'Riwayat pinjam' : 'Buku dipinjam' }}</p>
            <p class="mt-2 text-sm text-slate-400">
                {{ $isAdmin ? 'Lihat aktivitas peminjaman terkini di bawah.' : 'Pantau daftar buku yang masih kamu pinjam.' }}
            </p>
        </div>
    </section>

    <section id="katalog" class="mb-8">
        <div class="mb-5 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h3 class="text-2xl font-semibold text-white">{{ $isAdmin ? 'Buku Terbaru' : 'Katalog Buku' }}</h3>
                <p class="mt-1 text-sm text-slate-400">Menampilkan koleksi terbaru yang sudah tersedia di sistem.</p>
            </div>
            @if ($isAdmin)
                <a href="{{ route('admin.books.index') }}" class="text-sm font-medium text-sky-300 hover:text-sky-200">Buka halaman CRUD buku</a>
            @endif
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            @forelse ($books as $book)
                <article class="overflow-hidden rounded-3xl border border-white/10 bg-slate-900/80 shadow-lg shadow-slate-950/30">
                    <div class="grid gap-5 p-5 sm:grid-cols-[160px_1fr]">
                        <div class="overflow-hidden rounded-2xl bg-slate-800">
                            @if ($book->cover_url)
                                <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}" class="h-56 w-full object-cover">
                            @else
                                <div class="flex h-56 items-center justify-center text-sm text-slate-500">Tidak ada gambar</div>
                            @endif
                        </div>
                        <div class="flex flex-col">
                            <div>
                                <h4 class="text-xl font-semibold text-white">{{ $book->judul }}</h4>
                                <p class="mt-1 text-sm text-slate-400">Penulis: {{ $book->penulis }}</p>
                                <p class="mt-3 text-sm leading-6 text-slate-300">{{ $book->deskripsi }}</p>
                            </div>
                            <div class="mt-5 flex flex-wrap items-center gap-3">
                                <span class="rounded-full bg-sky-400/10 px-3 py-1 text-sm text-sky-200">
                                    Stok: {{ $book->stok }}
                                </span>

                                @if (! $isAdmin)
                                    @if (in_array($book->id, $activeLoanBookIds, true))
                                        <span class="rounded-full bg-emerald-400/10 px-3 py-1 text-sm text-emerald-200">Sudah dipinjam</span>
                                    @elseif ($book->stok > 0)
                                        <form method="POST" action="{{ route('loans.store', $book) }}">
                                            @csrf
                                            <button class="rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-400">
                                                Pinjam
                                            </button>
                                        </form>
                                    @else
                                        <span class="rounded-full bg-rose-400/10 px-3 py-1 text-sm text-rose-200">Stok habis</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-white/15 bg-slate-900/50 p-10 text-center text-slate-400 lg:col-span-2">
                    Belum ada buku yang ditambahkan.
                </div>
            @endforelse
        </div>
    </section>

    @if ($isAdmin)
        <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-lg shadow-slate-950/30">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-xl font-semibold text-white">Aktivitas Peminjaman Terbaru</h3>
                    <p class="mt-1 text-sm text-slate-400">Riwayat pinjam dan kembali dari seluruh user.</p>
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($recentLoans as $loan)
                    @php
                        $statusLabel = match ($loan->status) {
                            'pending' => 'Menunggu persetujuan',
                            'pinjam' => 'Sedang dipinjam',
                            'rejected' => 'Ditolak',
                            'kembali' => 'Sudah kembali',
                            default => ucfirst($loan->status),
                        };
                    @endphp
                    <div class="flex flex-col gap-3 rounded-2xl border border-white/10 bg-slate-950/60 p-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium text-white">{{ $loan->book?->judul ?? '-' }}</p>
                            <p class="text-sm text-slate-400">
                                {{ $loan->user?->name ?? '-' }} - {{ $loan->status }} - {{ $loan->created_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                        <span class="rounded-full bg-white/5 px-3 py-1 text-sm text-slate-200">
                            {{ $statusLabel }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">Belum ada aktivitas peminjaman.</p>
                @endforelse
            </div>
        </section>
    @else
        <section class="rounded-3xl border border-white/10 bg-slate-900/80 p-5 shadow-lg shadow-slate-950/30">
            <h3 class="text-xl font-semibold text-white">Peminjaman Saya</h3>
            <p class="mt-1 text-sm text-slate-400">Daftar buku yang sedang kamu pinjam saat ini.</p>

            <div class="mt-4 space-y-3">
                @forelse ($activeLoans as $loan)
                    <div class="flex flex-col gap-3 rounded-2xl border border-white/10 bg-slate-950/60 p-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-medium text-white">{{ $loan->book->judul }}</p>
                            <p class="text-sm text-slate-400">Dipinjam pada {{ $loan->borrowed_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                        <form method="POST" action="{{ route('loans.return', $loan) }}">
                            @csrf
                            <button class="rounded-2xl border border-white/10 px-4 py-2 text-sm font-semibold text-slate-200 transition hover:bg-white/5">
                                Kembalikan
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-white/15 bg-slate-950/40 p-6 text-sm text-slate-400">
                        Belum ada buku yang sedang dipinjam.
                    </div>
                @endforelse
            </div>
        </section>
    @endif
</x-layouts.app>
