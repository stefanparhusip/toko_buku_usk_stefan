@php
    $isFilled = $slot && ($slot->image || $slot->image_url || $slot->title || $slot->description || $slot->book_id);
    $slotLabel = $slotTag ?? ($slot ? ('Slot '.($slot->slot_number ?? $slot->position)) : 'Slot');
@endphp

<div class="slot-block {{ $class }} {{ $slot && ! $slot->is_active ? 'slot-inactive' : '' }}">
    @if ($slot)
        <span class="slot-tag">{{ $slotLabel }}</span>
        <a href="{{ route('admin.homepage-slots.edit', $slot) }}" class="btn btn-sm btn-light slot-edit-btn">Edit</a>

        @if ($slot->image_source)
            <img src="{{ $slot->image_source }}" alt="{{ $slot->title }}" class="slot-image">
            <div class="slot-overlay">
                <div class="fw-semibold">{{ $slot->title ?: 'Tanpa judul' }}</div>
                <small>{{ $slot->book?->title ?: \Illuminate\Support\Str::limit($slot->description, 44) }}</small>
            </div>
        @elseif ($isFilled)
            <div class="slot-empty">
                <div>
                    <strong>{{ $slot->title ?: 'Konten Slot' }}</strong>
                    <div class="small mt-1">{{ $slot->book?->title ?: \Illuminate\Support\Str::limit($slot->description, 50) }}</div>
                </div>
            </div>
        @else
            <div class="slot-empty">
                <div>
                    <strong>{{ $slotLabel }} kosong</strong>
                    <div class="small mt-1">Klik Edit untuk mengisi konten</div>
                </div>
            </div>
        @endif
    @else
        <div class="slot-empty">Slot tidak tersedia</div>
    @endif
</div>
