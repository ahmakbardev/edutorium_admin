<div>
    <label for="image" class="block text-gray-700">Gambar</label>
    <input type="file" id="image" wire:model="image" onchange="updatedImage(this)" class="block w-full mt-1 p-2 border border-gray-300 rounded">
    @error('image')
        <span class="text-red-500">{{ $message }}</span>
    @enderror

    <div wire:loading wire:target="image">Uploading...</div>
    <div wire:loading.remove wire:target="image">
        @if ($image)
            <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="mt-2 w-32 h-32 object-cover">
        @endif
    </div>
</div>
