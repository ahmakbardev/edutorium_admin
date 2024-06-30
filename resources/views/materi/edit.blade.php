@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 grid-rows-1 grid-flow-row-dense gap-6">
        <div>
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Edit Materi</h4>
                    </div>
                </div>
                <div class="container mx-auto py-8">
                    <form action="{{ route('materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="modul_id" class="block text-gray-700">Modul</label>
                            <select id="modul_id" name="modul_id"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}"
                                        {{ $materi->modul_id == $module->id ? 'selected' : '' }}>{{ $module->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="urutan_materi" class="block text-gray-700">Urutan Materi</label>
                            <input type="number" id="urutan_materi" name="urutan_materi"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded"
                                value="{{ $materi->urutan_materi }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="nama_materi" class="block text-gray-700">Nama Materi</label>
                            <input type="text" id="nama_materi" name="nama_materi"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded"
                                value="{{ $materi->nama_materi }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="materi" class="block text-gray-700">Materi</label>
                            <textarea id="materi" name="materi" class="block w-full mt-1 p-2 border border-gray-300 rounded" required>{!! $materi->materi !!}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="gambar" class="block text-gray-700">Gambar</label>
                            <input type="file" id="gambar" name="gambar"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                            @if ($materi->gambar)
                                <img src="{{ asset('storage/materi/' . $materi->gambar) }}" alt="Gambar"
                                    class="w-32 h-32 mt-2">
                            @endif
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update Materi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckfinder/3.5.1/ckfinder.js"></script>
    <script>
        var uploadImageCK = "{{ route('materi.upload') }}?_token={{ csrf_token() }}";

        ClassicEditor
            .create(document.querySelector('#materi'), {
                ckfinder: {
                    uploadUrl: uploadImageCK
                },
                mediaEmbed: {
                    previewsInData: true
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
