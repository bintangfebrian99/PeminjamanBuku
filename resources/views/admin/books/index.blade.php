<x-layouts.app title="Kelola Buku" heading="Kelola Buku">
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold text-white">CRUD Buku</h2>
            <p class="mt-1 text-sm text-slate-400">Tambah, ubah, dan hapus data buku beserta cover image.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="inline-flex rounded-2xl bg-sky-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-sky-400">
            Tambah Buku
        </a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-white/10 bg-slate-900/80 shadow-lg shadow-slate-950/30">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10 text-left">
                <thead class="bg-slate-950/60 text-xs uppercase tracking-[0.2em] text-slate-400">
                    <tr>
                        <th class="px-5 py-4">Buku</th>
                        <th class="px-5 py-4">Penulis</th>
                        <th class="px-5 py-4">Stok</th>
                        <th class="px-5 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse ($books as $book)
                        <tr class="align-top">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-16 w-12 overflow-hidden rounded-xl bg-slate-800">
                                        @if ($book->cover_url)
                                            <img src="{{ $book->cover_url }}" alt="{{ $book->judul }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-[10px] text-slate-500">
                                                No Cover
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white">{{ $book->judul }}</p>
                                        <p class="mt-1 text-sm text-slate-400">{{ \Illuminate\Support\Str::limit($book->deskripsi, 90) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-slate-300">{{ $book->penulis }}</td>
                            <td class="px-5 py-4 text-slate-300">{{ $book->stok }}</td>
                            <td class="px-5 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.books.edit', $book) }}" class="rounded-xl border border-white/10 px-3 py-2 text-sm text-slate-200 transition hover:bg-white/5">Edit</a>
                                    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl border border-rose-500/20 bg-rose-500/10 px-3 py-2 text-sm text-rose-200 transition hover:bg-rose-500/20">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-400">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
</x-layouts.app>
