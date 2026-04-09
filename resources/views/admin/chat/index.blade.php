@extends('admin.layouts.app', ['title' => 'Chat'])

@section('content')
    <style>
        .chat-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 1rem;
        }

        .chat-panel,
        .user-panel {
            border: 1px solid #dbe5f3;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(18, 50, 98, 0.08);
        }

        .user-list {
            max-height: 68vh;
            overflow-y: auto;
        }

        .user-item {
            display: block;
            text-decoration: none;
            color: #1f2b3d;
            border-bottom: 1px solid #edf2fb;
            padding: 0.9rem 1rem;
        }

        .user-item:hover,
        .user-item.active {
            background: #eef4ff;
        }

        .chat-window {
            background: linear-gradient(180deg, #f8fbff 0%, #f2f6fc 100%);
            border: 1px solid #e1e8f3;
            border-radius: 0.9rem;
            padding: 1rem;
            height: 56vh;
            min-height: 320px;
            overflow-y: auto;
        }

        .chat-row {
            display: flex;
            margin-bottom: 0.9rem;
        }

        .chat-row.justify-start {
            justify-content: flex-start;
        }

        .chat-row.justify-end {
            justify-content: flex-end;
        }

        .chat-bubble {
            max-width: min(78%, 700px);
            border-radius: 1rem;
            padding: 0.7rem 0.85rem;
            box-shadow: 0 4px 12px rgba(18, 44, 88, 0.08);
        }

        .chat-bubble.other {
            background: #eef2f7;
            border: 1px solid #d5deeb;
            color: #0f172a;
        }

        .chat-bubble.mine {
            background: #0f3468;
            border: 1px solid #0f3468;
            color: #ffffff;
        }

        .chat-meta {
            font-size: 0.74rem;
            opacity: 0.8;
            margin-bottom: 0.25rem;
        }

        .chat-text {
            margin: 0;
            white-space: pre-wrap;
            font-size: 0.93rem;
        }

        @media (max-width: 991px) {
            .chat-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center gap-2 mb-4 flex-wrap">
        <div>
            <h3 class="mb-1">Chat</h3>
            <p class="text-muted mb-0">Pilih user untuk melihat percakapan dan membalas pesan.</p>
        </div>
        @if ($selectedUser)
            <a href="{{ route('admin.chat.show', $selectedUser) }}" class="btn btn-outline-secondary">Refresh</a>
        @else
            <a href="{{ route('admin.chat.index') }}" class="btn btn-outline-secondary">Refresh</a>
        @endif
    </div>

    <div class="chat-layout">
        <div class="user-panel">
            <div class="p-3 border-bottom">
                <h6 class="mb-0">Daftar User</h6>
            </div>
            <div class="user-list">
                @forelse ($chatUsers as $chatUser)
                    <a
                        href="{{ route('admin.chat.show', $chatUser) }}"
                        class="user-item {{ $selectedUser && $selectedUser->id === $chatUser->id ? 'active' : '' }}"
                    >
                        <div class="fw-semibold">{{ $chatUser->name }}</div>
                        <div class="text-muted small">{{ $chatUser->email }}</div>
                    </a>
                @empty
                    <div class="text-center text-muted py-5">Belum ada user.</div>
                @endforelse
            </div>
        </div>

        <div class="chat-panel p-3 p-md-4">
            @if (! $selectedUser)
                <div class="text-center text-muted py-5">Belum ada user yang dapat dipilih.</div>
            @else
                <div class="mb-3">
                    <div class="fw-semibold">Chat dengan {{ $selectedUser->name }}</div>
                    <div class="text-muted small">{{ $selectedUser->email }}</div>
                </div>

                <div class="chat-window mb-3" id="chatWindow">
                    @forelse ($messages as $item)
                        @php
                            $isOwnMessage = $item->sender_id == auth()->id();
                        @endphp
                        <div class="chat-row {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
                            <div class="chat-bubble {{ $isOwnMessage ? 'mine' : 'other' }}">
                                <div class="chat-meta">
                                    {{ $isOwnMessage ? ($item->sender?->name ?? 'Anda') : ($item->sender?->name ?? 'User') }}
                                    • {{ $item->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                                </div>
                                <p class="chat-text">{{ $item->message }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">Belum ada pesan dengan user ini.</div>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('admin.chat.store', $selectedUser) }}">
                    @csrf
                    <div class="mb-2">
                        <textarea
                            name="message"
                            rows="3"
                            class="form-control @error('message') is-invalid @enderror"
                            placeholder="Tulis balasan untuk user..."
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-navy">Kirim Balasan</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatWindow = document.getElementById('chatWindow');
            if (chatWindow) {
                chatWindow.scrollTop = chatWindow.scrollHeight;
            }
        });
    </script>
@endsection
