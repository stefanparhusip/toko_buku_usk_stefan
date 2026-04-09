@extends('user.layouts.app', ['title' => 'Chat Admin'])

@section('content')
    <style>
        .chat-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(20, 46, 92, 0.08);
        }

        .chat-window {
            background: linear-gradient(180deg, #f8fbff 0%, #f2f6fc 100%);
            border: 1px solid #e1e8f3;
            border-radius: 0.9rem;
            padding: 1rem;
            height: 62vh;
            min-height: 360px;
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
            max-width: min(78%, 620px);
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
            white-space: pre-wrap;
            margin: 0;
            font-size: 0.93rem;
        }

        .chat-input textarea {
            resize: none;
            border-radius: 0.75rem;
            border-color: #cfdaec;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center gap-2 mb-4 flex-wrap">
        <div>
            <h2 class="section-title mb-1">Chat Admin</h2>
            <p class="text-muted mb-0">Kirim pertanyaan ke admin dan lihat balasan di sini.</p>
        </div>
        <a href="{{ route('chat.index') }}" class="btn btn-outline-secondary">Refresh</a>
    </div>

    <div class="card chat-card">
        <div class="card-body p-3 p-md-4">
            <div class="chat-window mb-3" id="chatWindow">
                @forelse ($messages as $item)
                    @php
                        $isOwnMessage = $item->sender_id == auth()->id();
                    @endphp
                    <div class="chat-row {{ $isOwnMessage ? 'justify-end' : 'justify-start' }}">
                        <div class="chat-bubble {{ $isOwnMessage ? 'mine' : 'other' }}">
                            <div class="chat-meta">
                                {{ $isOwnMessage ? 'Anda' : 'Admin' }}
                                • {{ $item->created_at?->timezone('Asia/Jakarta')->format('d M Y H:i') }}
                            </div>
                            <p class="chat-text">{{ $item->message }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        Belum ada percakapan. Mulai chat dengan admin sekarang.
                    </div>
                @endforelse
            </div>

            <form method="POST" action="{{ route('chat.store') }}" class="chat-input">
                @csrf
                <div class="mb-2">
                    <textarea
                        name="message"
                        rows="3"
                        class="form-control @error('message') is-invalid @enderror"
                        placeholder="Tulis pesan Anda ke admin..."
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                    <div class="text-muted small">Admin tujuan: {{ $admin->name }}</div>
                    <button type="submit" class="btn btn-navy">Kirim Pesan</button>
                </div>
            </form>
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
