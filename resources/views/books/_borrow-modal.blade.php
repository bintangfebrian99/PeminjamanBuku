<div id="borrowModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 animate-in fade-in zoom-in duration-200">
    <div class="bg-slate-900 rounded-3xl border border-white/10 w-full max-w-md p-8 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-semibold text-white">Ajukan Peminjaman Buku</h3>
            <button onclick="closeBorrowModal()" class="text-slate-400 hover:text-white p-1 -m-1 rounded-lg transition hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

<form method="POST" action="{{ route('loans.store', ['book' => '__BOOK_ID__']) }}" class="space-y-5" id="borrowForm">
            @csrf
            <input type="hidden" name="book_id" id="borrow-book-id" required>

            <div>
                <label class="block text-sm font-medium text-slate-200 mb-2">Tanggal Pengembalian yang Diharapkan</label>
                <input type="date" name="expected_return_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none transition">
                @error('expected_return_date')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-200 mb-2">Waktu Pengembalian yang Diharapkan</label>
                <input type="time" name="expected_return_time" required
                    class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-slate-100 focus:border-sky-400 focus:outline-none transition">
                @error('expected_return_time')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 rounded-2xl bg-emerald-500 px-6 py-3 font-semibold text-white transition hover:bg-emerald-400">
                    Ajukan Peminjaman
                </button>
                <button type="button" onclick="closeBorrowModal()" class="flex-1 rounded-2xl border border-white/10 px-6 py-3 font-semibold text-slate-200 transition hover:bg-white/5">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openBorrowModal(bookId) {
    document.getElementById('borrow-book-id').value = bookId;
    document.querySelector('#borrowForm').action = document.querySelector('#borrowForm').action.replace('__BOOK_ID__', bookId);
    document.getElementById('borrowModal').classList.remove('hidden');
}

function closeBorrowModal() {
    document.getElementById('borrowModal').classList.add('hidden');
    // reset form
    const form = document.querySelector('#borrowModal form');
    form.reset();
}
</script>

