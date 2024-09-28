<div wire:poll.5000ms>
    <!-- Konten yang ingin di-refresh otomatis setiap 5 detik -->
    @foreach($items as $item)
        <div>{{ $item->name }}</div>
    @endforeach
</div>  