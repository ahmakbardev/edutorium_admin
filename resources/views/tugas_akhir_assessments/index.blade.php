@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 xl:grid-cols-3 grid-rows-1 grid-flow-row-dense gap-6">
        <div class="xl:col-span-2">
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Penilaian Tugas Akhir</h4>
                    </div>
                </div>

                <div class="container mx-auto">
                    <div class="relative overflow-x-auto overflow-y-auto max-h-[458px]" data-simplebar="">
                        <table class="text-left w-full whitespace-nowrap">
                            <thead class="text-gray-700 sticky top-0">
                                <tr>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">User</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Nilai</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($progress as $item)
                                    @php
                                        $assessment = $assessments
                                            ->where('user_id', $item->user_id)
                                            ->where('tugas_akhir_id', $item->tugas_akhir_id)
                                            ->first();
                                    @endphp
                                    @if ($item)
                                        <tr class="hover:bg-slate-100 transition-all ease-in-out">
                                            <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                                {{ $item->user_name }}
                                            </td>
                                            <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                                @if ($assessment && isset($assessment->average_score))
                                                    {{ number_format($assessment->average_score, 2) }}
                                                @else
                                                    Belum Dinilai
                                                @endif
                                            </td>
                                            <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                                @if ($assessment)
                                                    <a href="{{ route('tugas_akhir_assessments.edit', ['id' => $assessment->id]) }}"
                                                        class="btn group btn-sm bg-yellow-500 text-white px-4 py-2 rounded">
                                                        Ubah Nilai
                                                    </a>
                                                @else
                                                    <a href="{{ route('tugas_akhir_assessments.create', ['tugas_akhir_id' => $item->tugas_akhir_id, 'user_id' => $item->user_id]) }}"
                                                        class="btn group btn-sm bg-yellow-500 text-white px-4 py-2 rounded">
                                                        Nilai
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card h-full shadow">
            <div class="border-b border-gray-300 px-5 py-4 flex justify-between items-center">
                <h4 class="text-base">Progres Kamu</h4>
                <div class="dropdown leading-4">
                    <button class="text-gray-600 p-1 hover:bg-gray-300 rounded-full transition-all" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i data-feather="more-vertical" class="w-4 h-4"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Edit Profil</a></li>
                        <li><a class="dropdown-item" href="#">Histori Bootcamp</a></li>
                        <li><a class="dropdown-item" href="#">Portfolio</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body overflow-hidden">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteAssessment(id) {
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus penilaian tugas akhir ini?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
