<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <p class="text-xs uppercase tracking-[0.3em] text-sky-300">Peminjaman Buku</p>
        <h1 class="text-2xl font-semibold text-white">Profil Saya</h1>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative">
            <button id="notification-bell" class="relative p-2 text-slate-400 hover:text-white transition" onclick="toggleNotifications()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if(isset($unreadCount) && $unreadCount > 0)
                <span class="absolute -top-1 -right-1 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-rose-500 text-xs font-bold text-white border-2 border-slate-950">{{ $unreadCount }}</span>
                @endif
            </button>
            <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-slate-900 border border-white/10 rounded-3xl shadow-2xl z-50 overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                <div class="p-4 border-b border-white/10">
                    <h4 class="font-semibold text-white text-lg">Notifikasi Peminjaman</h4>
                    <p class="text-sm text-slate-400">{{ $notifications->count() }} notifikasi terbaru</p>
                </div>
                <div id="notification-list" class="max-h-96 overflow-y-auto">
                    @forelse($notifications as $notification)
                    @php
                        $variant = $notification->data['variant'] ?? 'info';
                        $iconClass = match ($variant) {
                            'success' => 'bg-emerald-400/20 text-emerald-400 ring-1 ring-emerald-400/30',
                            'danger' => 'bg-rose-400/20 text-rose-400 ring-1 ring-rose-400/30',
                            default => 'bg-sky-400/20 text-sky-300 ring-1 ring-sky-400/30',
                        };
                        $iconLabel = match ($variant) {
                            'success' => 'OK',
                            'danger' => 'NO',
                            default => 'NEW',
                        };
                    @endphp
                    <div class="relative p-4 border-b border-white/5 hover:bg-white/5 group cursor-pointer transition-all @if(!$notification->read_at) bg-gradient-to-r from-sky-500/5 to-emerald-500/5 border-l-4 border-sky-400 @endif" data-notification-id="{{ $notification->id }}" onclick="markAsRead('{{ $notification->id }}')">
                        <div class="flex items-start gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl font-semibold text-sm shrink-0 {{ $iconClass }}">
                                {{ $iconLabel }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-white text-sm group-hover:text-sky-300 truncate pr-2">{{ $notification->data['title'] }}</p>
                                <p class="text-slate-300 mt-1 text-sm line-clamp-2 leading-relaxed">{{ $notification->data['message'] }}</p>
                                @if(isset($notification->data['reason']))
                                <p class="mt-2 text-xs text-rose-400 bg-rose-400/10 px-2.5 py-1.5 rounded-full font-medium inline-block border border-rose-400/30">{{ $notification->data['reason'] }}</p>
                                @endif
                                <p class="text-xs text-slate-500 mt-2">{{ $notification->created_at->format('d M Y H:i') }}</p>
                                @if(!$notification->read_at)
                                <div class="absolute inset-0 bg-sky-500/5 pointer-events-none rounded group-hover:opacity-0 transition-opacity"></div>
                                @endif
                            </div>
                            @if(!$notification->read_at)
                            <div class="flex h-6 w-6 items-center justify-center ml-2 opacity-0 group-hover:opacity-100 transition-all">
                                <div class="h-2 w-2 animate-ping rounded-full bg-sky-400"></div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <h4 class="text-slate-400 font-semibold">Tidak ada notifikasi baru</h4>
                        <p class="text-slate-500 text-sm mt-1">Kamu akan menerima notifikasi saat ada update peminjaman</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @script
        <script>
            let dropdownOpen = false;
            function toggleNotifications() {
                const dropdown = document.getElementById('notification-dropdown');
                dropdown.classList.toggle('hidden');
                dropdownOpen = !dropdownOpen;
            }

            window.onclick = function(event) {
                const bell = document.getElementById('notification-bell');
                const dropdown = document.getElementById('notification-dropdown');
                if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                    dropdownOpen = false;
                }
            }

            async function markAsRead(notificationId) {
                try {
                    await fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    // Update UI
                    const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (item) {
                        item.classList.remove('bg-gradient-to-r', 'from-sky-500/5', 'to-emerald-500/5', 'border-l-4', 'border-sky-400');
                        const indicator = item.querySelector('.ml-2');
                        if (indicator) {
                            indicator.remove();
                        }
                    }
                    location.reload();
                } catch (e) {
                    console.error('Failed to mark as read', e);
                }
            }
        </script>
        @endscript
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
