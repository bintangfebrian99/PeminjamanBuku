<x-layouts.app title="Tambah Buku" heading="Tambah Buku">
    <div class="max-w-3xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-lg shadow-slate-950/30">
        <form method="POST" action="{{ route('admin.books.store') }}" enctype="multipart/form-data">
            @include('admin.books._form', ['book' => null])
        </form>
    </div>
</x-layouts.app>
