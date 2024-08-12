@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 xl:grid-cols-3 grid-rows-1 grid-flow-row-dense gap-6">
        <div class="">
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Ubah Penilaian Tugas Akhir untuk {{ $user->name }}</h4>
                    </div>
                </div>

                <div class="container mx-auto py-8 px-5">
                    <form action="{{ route('tugas_akhir_assessments.update', ['id' => $assessment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="tugas_akhir_id" value="{{ $assessment->tugas_akhir_id }}">
                        <div class="mb-4">
                            <label for="tugas_akhir_name" class="block text-gray-700">Tugas Akhir</label>
                            <p class="text-lg font-semibold text-black">{{ $tugasAkhir->nama }}</p>
                            <button type="button"
                                class="btn gap-x-2 bg-indigo-600 text-white border-indigo-600 disabled:opacity-50 disabled:pointer-events-none hover:bg-indigo-800 hover:border-indigo-800 active:bg-indigo-800 active:border-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" role="button"
                                aria-controls="offcanvasRight">
                                Lihat Deskripsi
                            </button>
                        </div>
                        <div class="mb-4">
                            <label for="additional_info" class="block text-gray-700">Informasi Tambahan</label>
                            <p class="text-black">{{ $submission->additional_info }}</p>
                        </div>
                        <div class="mb-4">
                            <label for="web_url" class="block text-gray-700">URL Website</label>
                            <a href="{{ $submission->web_url }}" target="_blank"
                                class="text-blue-600 hover:underline">{{ $submission->web_url }}</a>
                        </div>
                        <div class="mb-4">
                            <label for="github_url" class="block text-gray-700">URL GitHub</label>
                            <a href="{{ $submission->github_url }}" target="_blank"
                                class="text-blue-600 hover:underline">{{ $submission->github_url }}</a>
                        </div>
                        <div class="mb-4">
                            <label for="kriteria_penilaian" class="block text-lg font-semibold text-black">Kriteria
                                Penilaian</label>
                            <div id="kriteria-container" class="grid grid-cols-2 gap-5 mb-2 my-3">
                                @if ($kriteria)
                                    @foreach ($kriteria as $kriteria_item)
                                        @php
                                            $nilai =
                                                collect(json_decode($assessment->kriteria_penilaian, true))->firstWhere(
                                                    'kriteria',
                                                    $kriteria_item,
                                                )['nilai'] ?? '';
                                        @endphp
                                        <div
                                            class="py-1 text-sm font-medium group hover:scale-105 transition-all ease-in-out rounded-full flex flex-col whitespace-nowrap">
                                            <span class="text-gray-700 text-wrap">{{ $kriteria_item }}</span>
                                            <input type="number" name="kriteria_penilaian[{{ $kriteria_item }}]"
                                                class="p-2 border ml-0 border-gray-300 rounded" placeholder="Nilai"
                                                value="{{ $nilai }}" required>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-red-500">Tidak ada kriteria untuk penilaian.</p>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 w-full text-white rounded">Perbarui
                            Penilaian</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="xl:col-span-2">
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Preview Tugas Akhir</h4>
                    </div>
                </div>
                <div class="container mx-auto py-8 px-5">
                    <div>
                        <iframe src="{{ $submission->web_url }}"
                            class="w-full h-[600px] border border-gray-300 rounded"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas for Description -->
    <div class="offcanvas translate-x-full fixed top-0 right-0 border-l w-full max-w-xl border-gray-300 transition-all duration-300 transform h-full invisible bg-white z-50"
        tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="flex items-center p-4">
            <h5 class="text-lg" id="offcanvasRightLabel">Deskripsi Tugas Akhir</h5>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 flex items-center justify-center"
                data-bs-dismiss="offcanvas" aria-label="Close">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>
        <div class="p-4">
            <div class="mb-4">
                <h5>Deskripsi PDF:</h5>
                <a href="{{ asset('storage/' . $tugasAkhir->deskripsi_pdf) }}" target="_blank"
                    class="text-blue-600 hover:underline">Lihat Deskripsi PDF</a>
            </div>
            <div class="mb-4 max-h-[800px]" data-simplebar="">
                <h5>Deskripsi:</h5>
                <p>{!! $tugasAkhir->deskripsi !!}</p>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Select all input elements that are used for kriteria penilaian
            const kriteriaInputs = document.querySelectorAll('input[name^="kriteria_penilaian"]');

            // Add event listener to each input to ensure the value does not exceed 100
            kriteriaInputs.forEach(input => {
                input.addEventListener('input', (event) => {
                    const value = parseInt(event.target.value, 10);
                    if (value > 100) {
                        event.target.value = 100;
                    } else if (value < 0) {
                        event.target.value = 0;
                    }
                });

                // Add event listener to prevent typing non-numeric characters
                input.addEventListener('keydown', (event) => {
                    // Allow backspace, delete, tab, escape, enter and '.'
                    if ([46, 8, 9, 27, 13].includes(event.keyCode) ||
                        // Allow: Ctrl+A, Command+A
                        (event.keyCode === 65 && (event.ctrlKey === true || event.metaKey ===
                            true)) ||
                        // Allow: Ctrl+C, Command+C
                        (event.keyCode === 67 && (event.ctrlKey === true || event.metaKey ===
                            true)) ||
                        // Allow: Ctrl+X, Command+X
                        (event.keyCode === 88 && (event.ctrlKey === true || event.metaKey ===
                            true)) ||
                        // Allow: home, end, left, right
                        (event.keyCode >= 35 && event.keyCode <= 39)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event
                            .keyCode < 96 || event.keyCode > 105)) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
