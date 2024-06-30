@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 xl:grid-cols-3 grid-rows-1 grid-flow-row-dense gap-6">
        <div class="xl:col-span-2">
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <!-- title -->
                    <div>
                        <h4 class="font-semibold text-base">Livecode Tutorial</h4>
                    </div>
                    <div>
                        <!-- button -->
                        <div class="leading-4">
                            <a href="{{ route('livecode_tutorials.create') }}"
                                class="btn gap-x-2 bg-white text-gray-800 border-gray-300 border disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-gray-700 hover:border-gray-700 active:bg-gray-700 active:border-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300"
                                type="button">
                                Buat Livecode Tutorial
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Tabel Daftar Livecode Tutorial -->
                <div class="container mx-auto">
                    {{-- @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif --}}
                    <div class="relative overflow-x-auto overflow-y-auto max-h-[458px]" data-simplebar="">
                        <table class="text-left w-full whitespace-nowrap">
                            <thead class="text-gray-700 sticky top-0">
                                <tr>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Modul</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Nama</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Deskripsi</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Deadline</th>
                                    <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($livecodeTutorials as $tutorial)
                                    <tr class="hover:bg-slate-100 transition-all ease-in-out">
                                        <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                            {{ $tutorial->module->name }}</td>
                                        <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                            {{ $tutorial->name }}</td>
                                        <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                            {{ $tutorial->description }}</td>
                                        <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                            {{ $tutorial->deadline }}</td>
                                        <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                            <a href="{{ route('livecode_tutorials.edit', $tutorial->id) }}"
                                                class="btn group btn-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 text-sky-400 group-hover:text-sky-500 transition-all ease-in-out mr-2"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-edit">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                    </path>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <button class="btn group btn-sm" onclick="deleteTutorial({{ $tutorial->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4 h-4 text-red-300 group-hover:text-red-500 transition-all ease-in-out mr-2"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17">
                                                    </line>
                                                    <line x1="14" y1="11" x2="14" y2="17">
                                                    </line>
                                                </svg>
                                            </button>
                                            <form id="delete-form-{{ $tutorial->id }}"
                                                action="{{ route('livecode_tutorials.destroy', $tutorial->id) }}"
                                                method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End of Tabel Daftar Livecode Tutorial -->
            </div>
        </div>
        <div class="card h-full shadow">
            <div class="border-b border-gray-300 px-5 py-4 flex justify-between items-center">
                <h4 class="text-base">Progres Kamu</h4>
                <!-- dropdown -->
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
            <!-- card body -->
            <div class="card-body overflow-hidden">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function deleteTutorial(id) {
            Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus livecode tutorial ini?',
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
