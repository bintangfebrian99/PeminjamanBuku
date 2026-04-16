<x-layouts.app title="Kelola Peminjaman" heading="Kelola Peminjaman">
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-semibold text-white">Semua Peminjaman</h2>
            <span class="rounded-full bg-sky-400/10 px-3 py-1 text-xs font-semibold text-sky-300">
                {{ $loans->total() }} total
            </span>
        </div>
        <a href="{{ route('admin.loans.create') }}" class="rounded-2xl bg-sky-500 px-6 py-3 font-semibold text-white hover:bg-sky-400 transition">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Buat Peminjaman
        </a>
    </div>

    <div class="rounded-3xl border border-white/10 bg-slate-900/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead>
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Pinjam</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider">Kembali</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-300 uppercase tracking-wider w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($loans as $loan)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-white">{{ $loan->book->judul }}</div>
                                <div class="text-sm text-slate-400">{{ $loan->book->penulis }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-white">{{ $loan->user->name }}</div>
                                <div class="text-xs text-slate-400">{{ $loan->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php $statusClass = match($loan->status) {
                                    'pending' => 'bg-amber-400/10 text-amber-300 border-amber-400/30',
                                    'pinjam' => 'bg-emerald-400/10 text-emerald-300 border-emerald-400/30',
                                    'rejected' => 'bg-rose-400/10 text-rose-300 border-rose-400/30',
                                    'kembali' => 'bg-sky-400/10 text-sky-300 border-sky-400/30',
                                    default => 'bg-slate-400/10 text-slate-300 border-slate-400/30',
                                }; @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full border {{ $statusClass }}">
                                    {{ match($loan->status) {
                                        'pending' => 'Menunggu',
                                        'pinjam' => 'Dipinjam',
                                        'rejected' => 'Ditolak',
                                        'kembali' => 'Dikembalikan',
                                        default => ucfirst($loan->status),
                                    } }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-300">
                                {{ $loan->borrowed_at?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-300">
                                {{ $loan->expected_return_date }} {{ $loan->expected_return_time }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.loans.edit', $loan) }}" class="text-sky-400 hover:text-sky-300 p-2 -m-2 rounded-xl hover:bg-sky-400/10 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.loans.destroy', $loan) }}" class="inline" onsubmit="return confirm('Hapus peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300 p-2 -m-2 rounded-xl hover:bg-rose-400/10 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-slate-400">
                                <svg class="mx-auto h-16 w-16 text-slate-500 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-white mb-2">Belum ada peminjaman</h3>
                                    <p class="mb-4">Mulai dengan membuat peminjaman baru.</p>
                                    <a href="{{ route('admin.loans.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-sky-500 px-6 py-3 font-semibold text-white hover:bg-sky-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Buat Peminjaman
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-12">
        {{ $loans->links() }}
    </div>
</x-layouts.app>

