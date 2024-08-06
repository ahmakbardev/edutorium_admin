@extends('layouts.layout')

@section('content')
    {{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/super-build/ckeditor.js"></script> --}}



    <div class="mx-6 my-10 grid grid-cols-1 grid-rows-1 grid-flow-row-dense gap-6">
        <div>
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <!-- title -->
                    <div>
                        <h4 class="font-semibold text-base">Modul</h4>
                    </div>
                    <div>
                        <!-- button -->
                        <div class="leading-4">
                            <button
                                class="btn gap-x-2 bg-white text-gray-800 border-gray-300 border disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-gray-700 hover:border-gray-700 active:bg-gray-700 active:border-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300"
                                type="button" onclick="showModal()">
                                Buat Modul
                            </button>
                        </div>
                    </div>
                </div>

                <div class="relative overflow-x-auto">
                    <!-- cards -->
                    <div class="relative max-h-96 overflow-y-auto p-4" data-simplebar="">
                        @livewire('module-list')

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="customModal"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-hidden bg-black bg-opacity-10 transition-opacity duration-300 hidden opacity-0 backdrop-blur-sm">
        <div
            class="modal-content relative bg-white rounded-lg px-3 py-3 md:px-8 md:py-8 transform translate-y-16 opacity-0 transition-transform duration-300 ease-in-out">
            <!-- Konten modal -->
            <div
                class="custom-art relative px-2 md:px-5 lg:px-0 max-lg:flex max-lg:flex-col grid place-content-center h-full gap-4">
                <div class="flex overflow-hidden justify-center items-center p-2 gap-3">
                    <livewire:create-module />
                </div>
                <!-- Livewire Component CreateModul -->
                <!-- Tombol close -->
            </div>
            <button id="closeModalBtn"
                class="absolute top-4 right-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full w-8 h-8 flex items-center justify-center focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <script>
        function showModal() {
            const customModal = document.getElementById('customModal');
            const modalContent = customModal.querySelector('.modal-content');
            customModal.classList.remove('hidden');
            setTimeout(function() {
                customModal.classList.add('opacity-100');
                modalContent.classList.add('translate-y-0', 'opacity-100');
                modalContent.style.transform = 'translateY(0)';
                document.body.classList.add('overflow-y-hidden');
            }, 50); // Tunggu 0.05 detik sebelum muncul secara smooth
        }

        function hideModal() {
            const customModal = document.getElementById('customModal');
            const modalContent = customModal.querySelector('.modal-content');
            document.body.classList.remove('overflow-y-hidden');

            modalContent.classList.remove('translate-y-0', 'opacity-100');
            modalContent.classList.add('translate-y-full');

            modalContent.style.transform = 'translateY(100%)';

            setTimeout(function() {
                customModal.classList.remove('opacity-100');
                customModal.classList.add('opacity-0');
                setTimeout(function() {
                    customModal.classList.add('hidden');
                }, 300); // Sesuaikan dengan durasi transition (0.3s)
            }, 300); // Sesuaikan dengan durasi transition (0.3s)
        }

        document.getElementById('closeModalBtn').addEventListener('click', hideModal);
        window.addEventListener('modulCreated', hideModal);
    </script>
@endsection
