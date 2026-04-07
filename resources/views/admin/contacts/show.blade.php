@extends('admin.layouts.app', ['title' => 'Detail Message'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Detail Message</h3>
            <p class="text-muted mb-0">Pesan dari {{ $contact->sender?->name ?? 'User' }}</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant mb-3">
        <div class="card-body">
            <div class="mb-2"><strong>User:</strong> {{ $contact->sender?->name ?? '-' }}</div>
            <div class="mb-2"><strong>Email:</strong> {{ $contact->sender?->email ?? '-' }}</div>
            <div class="mb-2"><strong>Subject:</strong> {{ $contact->subject }}</div>
            <div class="mb-0"><strong>Isi Pesan:</strong><br>{{ $contact->message }}</div>
        </div>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <h5 class="mb-3">Balas Pesan</h5>
            <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <textarea name="reply" rows="4" class="form-control @error('reply') is-invalid @enderror" required>{{ old('reply', $contact->reply) }}</textarea>
                    @error('reply')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-navy">Simpan Balasan</button>
            </form>
        </div>
    </div>
@endsection
