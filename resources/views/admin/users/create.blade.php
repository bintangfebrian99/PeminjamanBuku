<x-layouts.app title="Create User" heading="Buat User Baru">
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
            @csrf

            <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-white mb-8">Data User</h2>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('name') border-rose-400 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('email') border-rose-400 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                        <input type="password" name="password" required
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('password') border-rose-400 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Role</label>
                        <select name="role" required
                                class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('role') border-rose-400 @enderror">
                            <option value="">Pilih Role</option>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-white/10">
                <a href="{{ route('admin.users.index') }}" class="flex-1 rounded-2xl border border-white/10 py-3 px-6 text-slate-200 font-medium text-center hover:bg-white/5 transition">
                    Batal
                </a>
                <button type="submit" class="flex-1 rounded-2xl bg-sky-500 py-3 px-6 text-white font-semibold text-center hover:bg-sky-400 transition">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>

