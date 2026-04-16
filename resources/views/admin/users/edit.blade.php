<x-layouts.app title="Edit {{ $user->name }}" heading="Edit User">
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf @method('PUT')

            <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-8 shadow-xl">
                <h2 class="text-2xl font-bold text-white mb-8">Update Data User</h2>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('name') border-rose-400 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('email') border-rose-400 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Password Baru (kosongkan jika tidak ubah)</label>
                        <input type="password" name="password"
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('password') border-rose-400 @enderror"
                               placeholder="Kosongkan untuk tetap sama">
                        @error('password')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation"
                               class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-slate-400 focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Role</label>
                        <select name="role" required
                                class="w-full rounded-2xl border border-white/20 bg-white/5 px-4 py-3 text-white focus:border-sky-400/50 focus:outline-none focus:ring-1 focus:ring-sky-400/30 transition @error('role') border-rose-400 @enderror">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex gap-4 pt-6 border-t border-white/10">
                <a href="{{ route('admin.users.index') }}" class="flex-1 rounded-2xl border border-white/10 py-3 px-6 text-slate-200 font-medium text-center hover:bg-white/5 transition">
                    Kembali
                </a>
                <button type="submit" class="flex-1 rounded-2xl bg-sky-500 py-3 px-6 text-white font-semibold text-center hover:bg-sky-400 transition">
                    Update User
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>

