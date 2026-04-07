@extends('user.layouts.app', ['title' => 'Pesan Saya'])

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Pesan Saya</h2>
            <p class="text-muted mb-0">Lihat pesan yang sudah Anda kirim dan balasan dari admin.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Pesan</th>
                        <th>Balasan Admin</th>
                        <th>Tanggal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($messages as $message)
                        <tr>
                            <td class="fw-semibold">{{ $message->subject }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($message->message, 120) }}</td>
                            <td>
                                @if ($message->reply)
                                    <span class="text-success">{{ \Illuminate\Support\Str::limit($message->reply, 120) }}</span>
                                @else
                                    <span class="text-muted">Belum ada balasan</span>
                                @endif
                            </td>
                            <td>{{ $message->created_at?->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Anda belum mengirim pesan.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $messages->links() }}
    </div>
@endsection
