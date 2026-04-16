<x-layouts.app title="Users Management" heading="Kelola User">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Users</h1>
            <p class="text-slate-400 mt-1">Manage all registered users and their roles</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="rounded-2xl bg-sky-500 px-6 py-3 text-white font-semibold hover:bg-sky-400 transition">
            Tambah User
        </a>
    </div>

    <div class="rounded-3xl border border-white/10 bg-slate-900/80 p-6 shadow-xl">
        @if (session('success'))
            <x-flash-message type="success" :message="session('success')" />
        @endif
        @if (session('error'))
            <x-flash-message type="error" :message="session('error')" />
        @endif

        <div class="overflow-hidden rounded-2xl border border-white/10 bg-slate-950/50">
            <table class="w-full">
                <thead class="bg-slate-900/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Nama</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Role</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Dibuat</th>
                        <th class="w-32 px-6 py-4 text-right text-sm font-semibold text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($users as $user)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-5">
                                <div class="font-semibold text-white">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm text-slate-300">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $user->role === 'admin' ? 'bg-sky-400/10 text-sky-300 ring-1 ring-sky-400/30' : 'bg-emerald-400/10 text-emerald-300 ring-1 ring-emerald-400/30' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-300">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center gap-2 justify-end">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-sky-400 hover:text-sky-300 text-sm font-medium p-2 -m-2 rounded-lg hover:bg-sky-400/10 transition">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-400 hover:text-rose-300 text-sm font-medium p-2 -m-2 rounded-lg hover:bg-rose-400/10 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p>Belum ada user terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>

