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
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.24),_transparent_40%),radial-gradient(circle_at_bottom_right,_rgba(99,102,241,0.20),_transparent_30%)]"></div>
    <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-12">
        <div class="w-full max-w-md rounded-3xl border border-white/10 bg-slate-900/80 p-8 shadow-2xl shadow-slate-950/40 backdrop-blur">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
