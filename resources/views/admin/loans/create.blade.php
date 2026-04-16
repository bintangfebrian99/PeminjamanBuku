<x-layouts.app title="Buat Peminjaman Baru" heading="Buat Peminjaman Baru">
    <div class="max-w-3xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-xl shadow-slate-950/30">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-white">Tambah peminjaman manual</h2>
            <p class="mt-1 text-sm text-slate-400">Gunakan form ini jika admin ingin langsung membuat data peminjaman untuk user.</p>
        </div>
        <form method="POST" action="{{ route('admin.loans.store') }}">
            @include('admin.loans._form', ['users' => $users, 'books' => $books])
        </form>
    </div>
</x-layouts.app>

