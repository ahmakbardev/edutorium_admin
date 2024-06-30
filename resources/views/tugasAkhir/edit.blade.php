@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 grid-rows-1 grid-flow-row-dense gap-6">
        <div>
            <div class="card h-full shadow px-5">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Edit Tugas Akhir</h4>
                    </div>
                </div>
                <div class="container mx-auto py-8">
                    <form action="{{ route('tugasAkhir.update', $tugasAkhir->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="modul_id" class="block text-gray-700">Modul</label>
                            <select id="modul_id" name="modul_id"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                                @foreach ($modules as $module)
                                    <option value="{{ $module->id }}"
                                        {{ $module->id == $tugasAkhir->modul_id ? 'selected' : '' }}>{{ $module->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700">Nama</label>
                            <input type="text" id="nama" name="nama"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded" value="{{ $tugasAkhir->nama }}"
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-gray-700">Deskripsi (Optional)</label>
                            <textarea id="deskripsi" name="deskripsi" class="block w-full mt-1 p-2 border border-gray-300 rounded">{{ $tugasAkhir->deskripsi }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi_pdf" class="block text-gray-700">Deskripsi PDF (Optional)</label>
                            <input type="file" id="deskripsi_pdf" name="deskripsi_pdf"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                            @if ($tugasAkhir->deskripsi_pdf)
                                <a href="{{ asset('storage/' . $tugasAkhir->deskripsi_pdf) }}" target="_blank"
                                    class="text-blue-500">View current PDF</a>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="deadline" class="block text-gray-700">Deadline</label>
                            <input type="date" id="deadline" name="deadline"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded"
                                value="{{ $tugasAkhir->deadline }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="kriteria_penilaian" class="block text-gray-700">Kriteria Penilaian</label>
                            <div id="kriteria-container" class="flex flex-wrap gap-2 mb-2">
                                <!-- Dynamic badges will be added here -->
                                @foreach (json_decode($tugasAkhir->kriteria_penilaian, true) as $kriteria)
                                    <div class="bg-blue-500 px-2 py-1 text-white text-sm font-medium group hover:scale-105 transition-all ease-in-out rounded-full flex items-center whitespace-nowrap text-center space-x-2">
                                        <span>{{ $kriteria }}</span>
                                        <button type="button" class="remove-kriteria text-white hover:text-red-300 transition-all ease-in-out">
                                            <i data-feather="x" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex">
                                <input type="text" id="kriteria-input" class="flex-1 p-2 border border-gray-300 rounded"
                                    placeholder="Add criteria">
                                <button type="button" id="add-kriteria-btn"
                                    class="px-4 py-2 bg-green-500 text-white rounded ml-2">Add</button>
                            </div>
                        </div>
                        <input type="hidden" id="kriteria_penilaian" name="kriteria_penilaian" required>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Tugas Akhir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('ckeditor5/ckeditor.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#deskripsi'), {
                ckfinder: {
                    uploadUrl: "{{ route('tugasAkhir.upload', ['_token' => csrf_token()]) }}",
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

        $(document).ready(function() {
            let kriteria = @json(json_decode($tugasAkhir->kriteria_penilaian, true));

            function updateKriteriaField() {
                $('#kriteria_penilaian').val(JSON.stringify(kriteria));
            }

            $('#add-kriteria-btn').on('click', function() {
                const input = $('#kriteria-input').val();
                if (input) {
                    kriteria.push(input);
                    $('#kriteria-container').append(
                        `<div class="bg-blue-500 px-2 py-1 text-white text-sm font-medium group hover:scale-105 transition-all ease-in-out rounded-full flex items-center whitespace-nowrap text-center space-x-2">
                            <span>${input}</span>
                            <button type="button" class="remove-kriteria text-white hover:text-red-300 transition-all ease-in-out">
                                <i data-feather="x" class="w-4 h-4"></i>
                            </button>
                        </div>`
                    );
                    feather.replace();
                    $('#kriteria-input').val('');
                    updateKriteriaField();
                }
            });

            $('#kriteria-container').on('click', '.remove-kriteria', function() {
                const index = $(this).parent().index();
                kriteria.splice(index, 1);
                $(this).parent().remove();
                updateKriteriaField();
            });

            $('form').on('submit', function() {
                updateKriteriaField();
            });

            // Initial call to set the hidden input value
            updateKriteriaField();
        });
    </script>
@endsection

@push('scripts')
    <script>
        feather.replace();
    </script>
@endpush
