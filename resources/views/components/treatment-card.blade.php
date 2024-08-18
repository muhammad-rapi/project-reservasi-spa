<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <img class="w-full h-48 object-cover" src="{{ Storage::url($record->image) }}" alt="{{ $record->spa_type }}">
    <div class="p-4">
        <h3 class="text-lg font-semibold">{{ $record->spa_type }}</h3>
        <p class="text-gray-600">Rp {{ number_format($record->price, 0, ',', '.') }}</p>
    </div>
</div>
