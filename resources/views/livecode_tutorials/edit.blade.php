@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 grid-rows-1 grid-flow-row-dense gap-6">
        <div>
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Edit Livecode Tutorial</h4>
                    </div>
                </div>
                <div class="container mx-auto py-8">
                    <form action="{{ route('livecode_tutorials.update', $livecodeTutorial->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="module_id" class="block text-gray-700">Modul</label>
                            <select id="module_id" name="module_id"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}"
                                        {{ $livecodeTutorial->module_id == $module->id ? 'selected' : '' }}>
                                        {{ $module->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Nama</label>
                            <input type="text" id="name" name="name"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded"
                                value="{{ $livecodeTutorial->name }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700">Deskripsi</label>
                            <textarea id="description" name="description" class="block w-full mt-1 p-2 border border-gray-300 rounded" required>{{ $livecodeTutorial->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="tutorial" class="block text-gray-700">Tutorial</label>
                            <textarea id="tutorial" name="tutorial" class="block w-full mt-1 p-2 border border-gray-300 rounded" required>{{ $livecodeTutorial->tutorial }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="block text-gray-700">Deadline</label>
                            <input type="date" id="deadline" name="deadline"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded"
                                value="{{ $livecodeTutorial->deadline }}" required>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#tutorial'), {
                ckfinder: {
                    uploadUrl: "{{ route('materi.upload', ['_token' => csrf_token()]) }}",
                    options: {
                        resourceType: 'Images'
                    }
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