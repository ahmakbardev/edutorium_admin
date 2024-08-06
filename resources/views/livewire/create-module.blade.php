<div>
    @if (session()->has('message'))
        <div class="text-green-500 mb-4">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label for="name" class="block text-gray-700">Nama</label>
            <input type="text" id="name" wire:model="name"
                class="block w-full mt-1 p-2 border border-gray-300 rounded">
            @error('name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-gray-700">Deskripsi</label>
            <textarea id="description" wire:model.lazy="description" class="block w-full mt-1 p-2 border border-gray-300 rounded"></textarea>
            @error('description')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <livewire:modul-image-uploader />

        <div>
            <label for="status" class="block text-gray-700">Status</label>
            <select id="status" wire:model="status" class="block w-full mt-1 p-2 border border-gray-300 rounded">
                <option value="draft">Draft</option>
                <option value="publish">Publish</option>
            </select>
            @error('status')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Modul</button>
    </form>
</div>
