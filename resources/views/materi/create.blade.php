@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 grid-rows-1 grid-flow-row-dense gap-6">
        <div>
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Buat Materi Baru</h4>
                    </div>
                </div>
                <div class="container mx-auto py-8 px-5">
                    <form action="{{ route('materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="modul_id" class="block text-gray-700">Modul</label>
                            <select id="modul_id" name="modul_id"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="urutan_materi" class="block text-gray-700">Urutan Materi</label>
                            <input type="number" id="urutan_materi" name="urutan_materi"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="nama_materi" class="block text-gray-700">Nama Materi</label>
                            <input type="text" id="nama_materi" name="nama_materi"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="materi" class="block text-gray-700">Materi</label>
                            <textarea id="materi" name="materi" class="block w-full mt-1 p-2 border border-gray-300 rounded"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="file_gambar" class="block text-gray-700">Gambar</label>
                            <input type="file" id="file_gambar" name="file_gambar"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Materi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var uploadImageCK = "{{ route('materi.upload') }}?_token={{ csrf_token() }}";

        CKEDITOR.ClassicEditor.create(document.querySelector('#materi'), {
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
