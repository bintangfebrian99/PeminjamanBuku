<x-layouts.guest title="Login">
    <div class="mb-8">
        <p class="text-sm uppercase tracking-[0.3em] text-sky-300">Selamat datang</p>
        <h2 class="mt-2 text-3xl font-semibold text-white">Login ke sistem</h2>
        <p class="mt-2 text-sm text-slate-400">Masuk untuk mengelola buku atau meminjam buku.</p>
    </div>

    <x-flash-message />

    <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-sky-400 @error('email') border-rose-400 bg-rose-500/5 @enderror">
            @error('email')
                <p class="mt-1 text-sm text-rose-300">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200" for="password">Password</label>
            <input id="password" name="password" type="password" required
                class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-sky-400 @error('password') border-rose-400 bg-rose-500/5 @enderror">
            @error('password')
                <p class="mt-1 text-sm text-rose-300">{{ $message }}</p>
            @enderror
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-300">
            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-white/20 bg-slate-900 text-sky-400">
            Ingat saya
        </label>
        <button class="w-full rounded-2xl bg-sky-500 px-4 py-3 font-semibold text-white transition hover:bg-sky-400">
            Login
        </button>
    </form>

    <div class="mt-6 p-4 rounded-2xl border border-sky-400/30 bg-sky-500/5">
        <p class="text-xs text-sky-200 mb-1 font-medium">Test Credentials:</p>
        <p class="text-xs text-slate-300">Admin: admin@gmail.com / admin123</p>
        <p class="text-xs text-slate-300">User: user@gmail.com / user123</p>
    </div>

    <p class="mt-6 text-sm text-slate-400">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-medium text-sky-300 hover:text-sky-200">Daftar di sini</a>
    </p>
</x-layouts.guest>
