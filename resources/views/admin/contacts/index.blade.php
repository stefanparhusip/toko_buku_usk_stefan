@extends('admin.layouts.app', ['title' => 'Messages'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Messages / Contacts</h3>
            <p class="text-muted mb-0">Daftar pesan dari user untuk admin.</p>
        </div>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->sender?->name ?? 'User' }}</td>
                            <td>{{ $contact->subject }}</td>
                            <td>{{ $contact->created_at?->format('d M Y H:i') }}</td>
                            <td>
                                @if ($contact->reply)
                                    <span class="badge text-bg-success">Sudah Dibalas</span>
                                @else
                                    <span class="badge text-bg-warning">Belum Dibalas</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada pesan masuk.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $contacts->links() }}
    </div>
@endsection
