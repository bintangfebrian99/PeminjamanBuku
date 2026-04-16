<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Peminjaman Buku' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-100">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(34,197,94,0.18),_transparent_35%),radial-gradient(circle_at_bottom_left,_rgba(59,130,246,0.18),_transparent_30%)]"></div>
    <div class="mx-auto min-h-screen max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <header class="mb-8 rounded-3xl border border-white/10 bg-slate-900/80 px-5 py-4 shadow-xl shadow-slate-950/30 backdrop-blur">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-sky-300">Peminjaman Buku</p>
                    <h1 class="text-2xl font-semibold text-white">{{ $heading ?? 'Dashboard' }}</h1>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-200 transition hover:bg-white/5">Dashboard</a>
                    <a href="{{ route('profile') }}" class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-200 transition hover:bg-white/5">Profil</a>
                    <a href="{{ route('books.index') }}" class="rounded-xl border border-white/10 px-4 py-2 text-sm text-slate-200 transition hover:bg-white/5">Buku</a>
                    @if (auth()->user()?->isAdmin())
                        <a href="{{ route('admin.books.index') }}" class="rounded-xl border border-sky-400/30 bg-sky-400/10 px-4 py-2 text-sm text-sky-200 transition hover:bg-sky-400/20">Kelola Buku</a>
                        <a href="{{ route('admin.loans.index') }}" class="rounded-xl border border-emerald-400/30 bg-emerald-400/10 px-4 py-2 text-sm text-emerald-200 transition hover:bg-emerald-400/20">Kelola Peminjaman</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-xl bg-white px-4 py-2 text-sm font-medium text-slate-900 transition hover:bg-slate-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <x-flash-message />

        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
