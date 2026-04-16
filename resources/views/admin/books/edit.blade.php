<x-layouts.app title="Edit Buku" heading="Edit Buku">
    <div class="max-w-3xl rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-lg shadow-slate-950/30">
        <form method="POST" action="{{ route('admin.books.update', $book) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.books._form', ['book' => $book])
        </form>
    </div>
</x-layouts.app>
