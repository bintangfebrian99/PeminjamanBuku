Connection.php<x-layouts.app title="Admin Dashboard" heading="Admin Dashboard">
    <section class="mb-8 grid gap-6 lg:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 to-sky-950/70 p-6 shadow-2xl shadow-slate-950/30">
            <div class="flex items-center">
                <div class="rounded-2xl bg-sky-400/10 p-3">
                    <svg class="h-8 w-8 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-400">Total Users</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['users'] ?? User::count() }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 to-emerald-950/70 p-6 shadow-2xl shadow-slate-950/30">
            <div class="flex items-center">
                <div class="rounded-2xl bg-emerald-400/10 p-3">
                    <svg class="h-8 w-8 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-400">Total Books</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['books'] ?? Book::count() }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 to-rose-950/70 p-6 shadow-2xl shadow-slate-950/30">
            <div class="flex items-center">
                <div class="rounded-2xl bg-rose-400/10 p-3">
                    <svg class="h-8 w-8 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-slate-400">Active Loans</p>
                    <p class="text-3xl font-bold text-white">{{ $stats['active_loans'] ?? Loan::where('status', 'pinjam')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-900 to-indigo-950/70 p-6 shadow-2xl shadow-slate-950/30">
            <div class="flex items-center">
                <div class="rounded-2xl bg-indigo-400/10 p-3">
                    <svg class="h-8 w-8 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-400">Returned Loans</p>
                        <p class="text-3xl font-bold text-white">{{ $stats['returned_loans'] ?? Loan::where('status', 'kembali')->count() }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-xl">
                    <h3 class="text-xl font-semibold text-white mb-4">Quick Actions</h3>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <a href="{{ route('admin.books.index') }}" class="group rounded-2xl border border-white/10 p-6 hover:border-sky-400/50 hover:bg-sky-400/5 transition">
                            <svg class="mx-auto mb-4 h-12 w-12 text-slate-400 group-hover:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <h4 class="text-lg font-semibold text-white group-hover:text-sky-300">Manage Books</h4>
                            <p class="text-sm text-slate-400 mt-1">CRUD books</p>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="group rounded-2xl border border-white/10 p-6 hover:border-emerald-400/50 hover:bg-emerald-400/5 transition">
                            <svg class="mx-auto mb-4 h-12 w-12 text-slate-400 group-hover:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <h4 class="text-lg font-semibold text-white group-hover:text-emerald-300">Manage Users</h4>
                            <p class="text-sm text-slate-400 mt-1">CRUD users & roles</p>
                        </a>
                        <a href="{{ route('books.index') }}" class="group rounded-2xl border border-white/10 p-6 hover:border-indigo-400/50 hover:bg-indigo-400/5 transition">
                            <svg class="mx-auto mb-4 h-12 w-12 text-slate-400 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.5h3m1 3H4.5a2.5 2.5 0 01-2.5-2.5V8.5a2.5 2.5 0 012.5-2.5H18a2.5 2.5 0 012.5 2.5V18a2.5 2.5 0 01-2.5 2.5h-2.236z"/>
                            </svg>
                            <h4 class="text-lg font-semibold text-white group-hover:text-indigo-300">Public Catalog</h4>
                            <p class="text-sm text-slate-400 mt-1">View as user</p>
                        </a>
                    </div>
                </div>
            </div>
            <div>
                <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-xl">
                    <h3 class="text-xl font-semibold text-white mb-4">Recent Activity</h3>
                    <div class="space-y-3">
                        @php
                            $recentLoans = \\App\\Models\\Loan::with(['user', 'book'])->latest()->take(5)->get();
                        @endphp
                        @forelse($recentLoans as $loan)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5">
                                <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                                <div>
                                    <p class="font-medium text-white">{{ $loan->user->name }} pinjam {{ Str::limit($loan->book->judul, 30) }}</p>
                                    <p class="text-xs text-slate-400">{{ $loan->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400 text-center py-4">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>

