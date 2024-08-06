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
                <div class="container mx-auto py-8 px-5">
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
                        <div class="mb-4">
                            <label for="kriteria" class="block text-gray-700">Kriteria Penilaian</label>
                            <div id="kriteria-container" class="flex flex-wrap gap-2 mb-2">
                                @if (!empty(json_decode($livecodeTutorial->kriteria, true)))
                                    @foreach (json_decode($livecodeTutorial->kriteria, true) as $kriteria)
                                        <div
                                            class="bg-blue-500 px-2 py-1 text-white text-sm font-medium group hover:scale-105 transition-all ease-in-out rounded-full flex items-center whitespace-nowrap text-center space-x-2">
                                            <span>{{ $kriteria }}</span>
                                            <button type="button"
                                                class="remove-kriteria text-white hover:text-red-300 transition-all ease-in-out">
                                                <i data-feather="x" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="flex">
                                <input type="text" id="kriteria-input" class="flex-1 p-2 border border-gray-300 rounded"
                                    placeholder="Add criteria">
                                <button type="button" id="add-kriteria-btn"
                                    class="px-4 py-2 bg-green-500 text-white rounded ml-2">Add</button>
                            </div>
                            <input type="hidden" name="kriteria" id="kriteria" value="{{ $livecodeTutorial->kriteria }}">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var uploadImageCK = "{{ route('livecode_tutorials.upload') }}?_token={{ csrf_token() }}";

        function initializeCKEditor(selector) {
            CKEDITOR.ClassicEditor.create(document.querySelector(selector), {
                toolbar: {
                    items: [
                        "findAndReplace", "selectAll", "|",
                        "heading", "|",
                        "fontSize", "fontFamily", "fontColor", "fontBackgroundColor", "highlight", "|",
                        "bulletedList", "numberedList", "todoList", "|",
                        "outdent", "indent", "|",
                        "undo", "redo", "|",
                        "specialCharacters", "horizontalLine", "|",
                        "link", "insertImage", "blockQuote", "insertTable", "mediaEmbed",
                        "-",
                        "alignment", "|",
                        "bold", "italic", "strikethrough", "underline", "code", "subscript", "superscript",
                        "removeFormat", "|",
                        "exportPDF", "exportWord", "|",
                    ],
                    shouldNotGroupWhenFull: true
                },
                removePlugins: [
                    'RealTimeCollaborativeComments',
                    'RealTimeCollaborativeTrackChanges',
                    'RealTimeCollaborativeRevisionHistory',
                    'PresenceList',
                    'Comments',
                    'TrackChanges',
                    'TrackChangesData',
                    'RevisionHistory',
                    'Pagination',
                    'WProofreader',
                    'MathType',
                    'WebSocketGateway'
                ],
                ckfinder: {
                    uploadUrl: uploadImageCK,
                    options: {
                        resourceType: 'Images'
                    }
                },
                mediaEmbed: {
                    previewsInData: true
                }
            }).then(editor => {
                editor.ui.view.editable.element.style.minHeight = "200px";
                editor.ui.view.editable.element.style.borderBottomLeftRadius = "15px";
                editor.ui.view.editable.element.style.borderBottomRightRadius = "15px";
                editor.ui.view.editable.element.closest('.ck-editor').style.borderRadius = "15px";
            }).catch(error => {
                console.error(error);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // initializeCKEditor('#description');
            initializeCKEditor('#tutorial');

            let kriteria = @json(json_decode($livecodeTutorial->kriteria, true) ?? []);

            document.getElementById('add-kriteria-btn').addEventListener('click', function() {
                const input = document.getElementById('kriteria-input').value;
                if (input) {
                    kriteria.push(input);
                    document.getElementById('kriteria-container').insertAdjacentHTML('beforeend',
                        `<div class="bg-blue-500 px-2 py-1 text-white text-sm font-medium group hover:scale-105 transition-all ease-in-out rounded-full flex items-center whitespace-nowrap text-center space-x-2">
                            <span>${input}</span>
                            <button type="button" class="remove-kriteria text-white hover:text-red-300 transition-all ease-in-out">
                                <i data-feather="x" class="w-4 h-4"></i>
                            </button>
                        </div>`
                    );
                    feather.replace();
                    document.getElementById('kriteria-input').value = '';
                    updateKriteriaField();
                }
            });

            document.getElementById('kriteria-container').addEventListener('click', function(e) {
                if (e.target.closest('.remove-kriteria')) {
                    const index = Array.from(e.currentTarget.children).indexOf(e.target.closest(
                        '.remove-kriteria').parentElement);
                    kriteria.splice(index, 1);
                    e.target.closest('.remove-kriteria').parentElement.remove();
                    updateKriteriaField();
                }
            });

            function updateKriteriaField() {
                document.getElementById('kriteria').value = JSON.stringify(kriteria);
            }

            document.querySelector('form').addEventListener('submit', updateKriteriaField);
        });
    </script>
    <style>
        .ck-editor__editable {
            border-bottom-left-radius: 15px !important;
            border-bottom-right-radius: 15px !important;
            min-height: 200px;
            /* border: 0; */
        }

        .ck-toolbar {
            background: #F2F4F7 !important;
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }
    </style>
@endsection
