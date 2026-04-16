<x-layouts.app title="Katalog Buku" heading="Katalog Buku">
    <section class="mb-8">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-3xl font-semibold text-white">Koleksi Buku</h2>
                <p class="mt-1 text-sm text-slate-400">Temukan buku favoritmu dan pinjam sekarang juga.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.books.index') }}" class="rounded-xl border border-sky-400/30 bg-sky-400/10 px-6 py-2.5 text-sm text-sky-200 transition hover:bg-sky-400/20 whitespace-nowrap">
                        Kelola Buku (Admin)
                    </a>
                @endif
            </div>
        </div>

        {{-- Search Form --}}
        <div class="mb-8 rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari judul atau penulis..."
                        class="w-full rounded-2xl border border-white/20 bg-white/5 px-5 py-3 text-sm backdrop-blur transition focus:border-sky-400/50 focus:outline-none"
                    >
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </div>
                <button type="submit" class="rounded-2xl bg-sky-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-sky-400 whitespace-nowrap">
                    Cari Buku
                </button>
                @if($search)
                    <a href="{{ route('books.index') }}" class="rounded-2xl border border-white/10 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:bg-white/5 whitespace-nowrap">
                        Bersihkan
                    </a>
                @endif
            </form>
        </div>
    </section>

    {{-- Stats Overview --}}
    @auth
    <section class="mb-8 grid gap-4 md:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center">
            <p class="text-sm text-slate-400">Total Buku</p>
            <p class="mt-2 text-2xl font-semibold text-white">{{ $books->total() }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center">
            <p class="text-sm text-slate-400">Tersedia</p>
            <p class="mt-2 text-2xl font-semibold text-white">{{ $books->getCollection()->where('stok', '>', 0)->count() }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center">
            <p class="text-sm text-slate-400">Stok Habis</p>
            <p class="mt-2 text-2xl font-semibold text-white">{{ $books->getCollection()->where('stok', 0)->count() }}</p>
        </div>
        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 text-center">
            <p class="text-sm text-slate-400">Halaman</p>
            <p class="mt-2 text-2xl font-semibold text-white">{{ $books->currentPage() }} / {{ $books->lastPage() }}</p>
        </div>
    </section>
    @endauth

    {{-- Books Grid --}}
    <section class="mb-12">
        @if($books->count() > 0)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($books as $book)
                    <article class="group overflow-hidden rounded-3xl border border-white/10 bg-slate-900/80 shadow-lg shadow-slate-950/30 transition-all hover:shadow-xl hover:shadow-sky-950/30">
                        <div class="overflow-hidden rounded-t-3xl bg-gradient-to-br from-slate-800/50 to-transparent p-6">
                            @if ($book->cover_url)
                                <img
                                    src="{{ $book->cover_url }}"
                                    alt="{{ $book->judul }}"
                                    class="h-48 w-full cursor-pointer object-cover transition group-hover:scale-105 group-hover:brightness-110"
                                    loading="lazy"
                                >
                            @else
                                <div class="flex h-48 items-center justify-center rounded-2xl bg-slate-700 text-sm text-slate-400 transition group-hover:bg-slate-600">
                                    Tidak ada sampul
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="mb-4">
                                <h3 class="mb-2 text-xl font-semibold text-white line-clamp-2 group-hover:text-sky-300 transition">
                                    {{ $book->judul }}
                                </h3>
                                <p class="text-sm text-slate-400 line-clamp-1">
                                    {{ $book->penulis }}
                                </p>
                            </div>

                            <p class="mb-6 line-clamp-3 text-sm leading-relaxed text-slate-300">
                                {{ $book->deskripsi }}
                            </p>

                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-sky-400/10 px-3 py-1.5 text-xs font-semibold text-sky-300">
                                    Stok: {{ $book->stok }}
                                </span>

                                @auth
@php $isActiveLoan = auth()->user()->loans()->where('book_id', $book->id)->whereIn('status', ['pinjam', 'pending'])->exists(); @endphp
                                    @if($isActiveLoan)
                                        <span class="rounded-full bg-emerald-400/10 px-3 py-1.5 text-xs font-semibold text-emerald-300">
                                            ✓ Sudah dipinjam
                                        </span>
@elseif($book->stok > 0)
                                        <button onclick="openBorrowModal({{ $book->id }})"
                                            class="rounded-2xl bg-emerald-500 px-6 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-400 hover:shadow-md hover:shadow-emerald-950/50 whitespace-nowrap cursor-pointer"
                                        >
                                            Ajukan Pinjam
                                        </button>
                                    @else
                                        <span class="rounded-full bg-rose-400/10 px-3 py-1.5 text-xs font-semibold text-rose-300">
                                            Habis
                                        </span>
                                    @endif
                                @else
                                    <span class="rounded-full bg-slate-600/50 px-3 py-1.5 text-xs text-slate-300">
                                        Login untuk pinjam
                                    </span>
                                @endauth
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-24 rounded-3xl border-2 border-dashed border-white/20 bg-slate-900/50">
                            <svg class="mx-auto h-16 w-16 text-slate-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <h3 class="text-xl font-semibold text-white mb-2">Belum ada buku</h3>
                            <p class="text-slate-400 mb-6 max-w-sm mx-auto">Koleksi buku akan muncul di sini setelah admin menambahkan.</p>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.books.create') }}" class="rounded-2xl bg-sky-500 px-8 py-3 text-sm font-semibold text-white transition hover:bg-sky-400">
                                        Tambah Buku Pertama
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($books->hasPages())
                <div class="mt-12">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </section>
@include('books._borrow-modal')
</x-layouts.app>
