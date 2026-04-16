<x-layouts.app title="Edit Peminjaman" heading="Edit Peminjaman">
    <div class="max-w-3xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-xl shadow-slate-950/30">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-white">Perbarui data peminjaman</h2>
            <p class="mt-1 text-sm text-slate-400">Atur ulang user, buku, status, dan jadwal pengembalian dari satu form.</p>
        </div>
        <form method="POST" action="{{ route('admin.loans.update', $loan) }}">
            @method('PUT')
            @include('admin.loans._form', ['users' => $users, 'books' => $books, 'loan' => $loan])
        </form>
    </div>
</x-layouts.app>

