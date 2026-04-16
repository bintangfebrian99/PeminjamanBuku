<x-layouts.app title="Profil" heading="Profil Saya">
    <section class="mb-12">
        <div class="grid gap-8 lg:grid-cols-3">
            {{-- Profile Card --}}
            <div class="lg:col-span-1">
                <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 to-slate-950/70 p-8 text-center shadow-2xl shadow-slate-950/30">
                    <div class="mx-auto h-24 w-24 rounded-full bg-gradient-to-r from-sky-400 to-emerald-400"></div>
                    <h2 class="mt-6 text-2xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="mt-1 text-sm text-slate-400">{{ $user->email }}</p>
                    <p class="mt-4 rounded-full bg-sky-400/10 px-4 py-2 text-sm font-semibold text-sky-300">
                        {{ $user->isAdmin() ? 'Admin' : 'User' }}
                    </p>
                    <div class="mt-8 grid grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-white/5 p-4">
                            <p class="text-2xl font-bold text-white">{{ $stats['total_loans'] }}</p>
                            <p class="text-xs text-slate-400 uppercase tracking-wide">Total Pinjam</p>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4">
                            <p class="text-2xl font-bold text-white">{{ $stats['active_loans'] }}</p>
                            <p class="text-xs text-slate-400 uppercase tracking-wide">Sedang Dipinjam</p>
                        </div>
                        <div class="rounded-2xl bg-white/5 p-4">
                            <p class="text-2xl font-bold text-white">{{ $stats['returned_loans'] }}</p>
                            <p class="text-xs text-slate-400 uppercase tracking-wide">Sudah Dikembalikan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="lg:col-span-2">
                <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-8 shadow-xl shadow-slate-950/30">
                    <h3 class="mb-6 text-xl font-semibold text-white">Aksi Cepat</h3>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <a href="{{ route('books.index') }}" class="group rounded-2xl border border-white/10 p-6 text-center transition-all hover:border-sky-400/50 hover:bg-sky-400/5">
                            <svg class="mx-auto mb-3 h-10 w-10 text-slate-400 group-hover:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="font-semibold text-white group-hover:text-sky-300">Pinjam Buku</p>
                        </a>
                        <a href="{{ route('dashboard') }}" class="group rounded-2xl border border-white/10 p-6 text-center transition-all hover:border-emerald-400/50 hover:bg-emerald-400/5">
                            <svg class="mx-auto mb-3 h-10 w-10 text-slate-400 group-hover:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-semibold text-white group-hover:text-emerald-300">Dashboard</p>
                        </a>
                        @if($user->isAdmin())
                        <a href="{{ route('admin.books.index') }}" class="group rounded-2xl border border-white/10 p-6 text-center transition-all hover:border-sky-500/50 hover:bg-sky-500/5 sm:col-span-2 lg:col-span-1">
                            <svg class="mx-auto mb-3 h-10 w-10 text-slate-400 group-hover:text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <p class="font-semibold text-white group-hover:text-sky-400">Kelola Buku Admin</p>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Loan History --}}
    <section>
        <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/30">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-white">Riwayat Peminjaman</h3>
                    <p class="mt-1 text-sm text-slate-400">Semua buku yang pernah kamu pinjam</p>
                </div>
                @if($loans->count() > 0)
                    <div class="text-sm text-slate-400">
                        Menampilkan {{ $loans->firstItem() ?? 0 }}-{{ $loans->lastItem() ?? 0 }} dari {{ $loans->total() }} peminjaman
                    </div>
                @endif
            </div>

            @if($loans->count() > 0)
                <div class="mt-8 overflow-hidden rounded-3xl border border-white/10 bg-slate-950/50">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-white/10 bg-slate-900/50">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Buku</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Dipinjam</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($loans as $loan)
                                @php
                                    $statusClass = match ($loan->status) {
                                        'pending' => 'bg-amber-400/10 text-amber-300 ring-1 ring-amber-400/30',
                                        'pinjam' => 'bg-emerald-400/10 text-emerald-300 ring-1 ring-emerald-400/30',
                                        'rejected' => 'bg-rose-400/10 text-rose-300 ring-1 ring-rose-400/30',
                                        'kembali' => 'bg-sky-400/10 text-sky-300 ring-1 ring-sky-400/30',
                                        default => 'bg-white/5 text-slate-300 ring-1 ring-white/10',
                                    };

                                    $statusLabel = match ($loan->status) {
                                        'pending' => 'Menunggu Persetujuan',
                                        'pinjam' => 'Sedang Dipinjam',
                                        'rejected' => 'Ditolak',
                                        'kembali' => 'Sudah Dikembalikan',
                                        default => ucfirst($loan->status),
                                    };
                                @endphp
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-6 py-5">
                                        <div class="font-semibold text-white max-w-xs truncate">{{ $loan->book->judul }}</div>
                                        <div class="text-sm text-slate-400 truncate">{{ $loan->book->penulis }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-slate-300">{{ $loan->borrowed_at?->format('d M Y H:i') ?? $loan->created_at?->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-5">
                                        @if($loan->status === 'pinjam')
                                            <form method="POST" action="{{ route('loans.return', $loan) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="rounded-xl bg-emerald-500 px-4 py-1.5 text-xs font-semibold text-white hover:bg-emerald-400 transition">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($loans->hasPages())
                    <div class="mt-8">
                        {{ $loans->links() }}
                    </div>
                @endif
            @else
                <div class="mt-8 rounded-3xl border-2 border-dashed border-white/20 bg-slate-900/50 p-16 text-center">
                    <svg class="mx-auto h-16 w-16 text-slate-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h4 class="text-xl font-semibold text-white mb-2">Belum ada riwayat peminjaman</h4>
                    <p class="text-slate-400 mb-6 max-w-md mx-auto">Mulai pinjam buku untuk melihat riwayat di sini.</p>
                    <a href="{{ route('books.index') }}" class="inline-flex rounded-2xl bg-emerald-500 px-6 py-3 text-sm font-semibold text-white hover:bg-emerald-400 transition">
                        Pinjam Buku Pertama
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-layouts.app>
