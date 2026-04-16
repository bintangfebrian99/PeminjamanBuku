<x-layouts.guest title="Register">
    <div class="mb-8">
        <p class="text-sm uppercase tracking-[0.3em] text-sky-300">Buat akun</p>
        <h2 class="mt-2 text-3xl font-semibold text-white">Register user baru</h2>
        <p class="mt-2 text-sm text-slate-400">Akun baru otomatis memiliki role <span class="font-medium text-slate-200">user</span>.</p>
    </div>

    <x-flash-message />

    <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200" for="name">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-sky-400">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-sky-400">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200" for="password">Password</label>
            <input id="password" name="password" type="password" required
                class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-sky-400">
        </div>
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-200" for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="w-full rounded-2xl border border-white/10 bg-slate-900 px-4 py-3 text-slate-100 outline-none transition placeholder:text-slate-500 focus:border-sky-400">
        </div>
        <button class="w-full rounded-2xl bg-sky-500 px-4 py-3 font-semibold text-white transition hover:bg-sky-400">
            Daftar
        </button>
    </form>

    <p class="mt-6 text-sm text-slate-400">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-medium text-sky-300 hover:text-sky-200">Login di sini</a>
    </p>
</x-layouts.guest>
