<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 py-5 gap-4">
    @if (session()->has('message'))
        <div id="toast-container" class="fixed top-4 right-4 flex flex-col space-y-2 z-[200]">
            <div class="own-toast bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-lg rounded transform transition-transform duration-300 translate-y-0 opacity-100"
                role="alert">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @foreach ($modules as $module)
        <div wire:key="module-{{ $module->id }}"
            class="bg-white shadow-md rounded-md overflow-hidden flex flex-col hover:scale-105 hover:shadow-lg transition-all ease-in-out">
            @livewire('module-update-status', ['module' => $module], key('module-status-' . $module->id))
            <div class="flex gap-3 my-2 px-3 items-center justify-between">
                <div class="flex flex-col w-fit">
                    <h1 class="text-base inline">{{ $module->name }}</h1>
                    <p class="text-xs inline">{{ $module->created_at->format('d M Y') }}</p>
                </div>
                <div class="flex">
                    <button class="group w-fit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"
                        data-module-id="{{ $module->id }}" data-module-name="{{ $module->name }}"
                        data-module-description="{{ $module->description }}" onclick="showEditModal(this)">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 hover:text-sky-500 transition-all ease-in-out mr-2" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-edit">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </button>
                    <button class="group w-fit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete"
                        onclick="confirmDelete({{ $module->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 hover:text-red-500 transition-all ease-in-out mr-2" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-trash-2">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                            </path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Edit -->
    <div id="editModal"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-y-hidden bg-black bg-opacity-10 transition-opacity duration-300 hidden opacity-0 backdrop-blur-sm">
        <div
            class="modal-content relative bg-white rounded-lg px-3 py-3 md:px-8 w-full max-w-xl md:py-8 transform translate-y-16 opacity-0 transition-transform duration-300 ease-in-out">
            <!-- Konten modal -->
            <div
                class="custom-art relative px-2 md:px-5 lg:px-0 max-lg:flex max-lg:flex-col grid h-full w-full gap-4">
                <div class="flex overflow-hidden w-full p-2 gap-3">
                    <form id="editForm" class="space-y-4 w-full">
                        <div class="w-full">
                            <label for="editName" class="block text-gray-700">Nama</label>
                            <input type="text" id="editName"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded">
                        </div>

                        <div class="w-full">
                            <label for="editDescription" class="block text-gray-700">Deskripsi</label>
                            <textarea id="editDescription" class="block w-full mt-1 p-2 border border-gray-300 rounded"></textarea>
                        </div>

                        <button type="button" onclick="saveEdit()"
                            class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
            <button id="closeEditModalBtn"
                class="absolute top-4 right-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-full w-8 h-8 flex items-center justify-center focus:outline-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showEditModal(button) {
            const moduleId = $(button).data('module-id');
            const name = $(button).data('module-name');
            const description = $(button).data('module-description');
            const status = $(button).data('module-status');

            $('#editModal').removeClass('hidden').addClass('opacity-100');
            $('#editForm').data('moduleId', moduleId);
            $('#editName').val(name);
            $('#editDescription').val(decodeHtml(description));
            $('#editStatus').val(status);
            setTimeout(function() {
                $('.modal-content').removeClass('translate-y-16').addClass('translate-y-0 opacity-100');
                $('body').addClass('overflow-y-hidden');
            }, 50); // Tunggu 0.05 detik sebelum muncul secara smooth
        }

        function hideEditModal() {
            $('#editModal').addClass('opacity-0');
            $('.modal-content').removeClass('translate-y-0').addClass('translate-y-16 opacity-0'); // Reset class
            $('body').removeClass('overflow-y-hidden');
            setTimeout(function() {
                $('#editModal').addClass('hidden');
            }, 300); // Sesuaikan dengan durasi transition (0.3s)
        }

        $('#closeEditModalBtn').on('click', hideEditModal);

        function saveEdit() {
            const moduleId = $('#editForm').data('moduleId');
            const name = $('#editName').val();
            const description = $('#editDescription').val();
            const status = $('#editStatus').val();

            @this.call('updateModule', moduleId, name, description, status);
        }

        document.addEventListener('livewire:update', function() {
            feather.replace();
        });

        function confirmDelete(moduleId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteModule', moduleId);
                }
            })
        }

        function decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.own-toast').each(function(index) {
                $(this).queue(function(next) {
                    $(this).removeClass('translate-y-[-10px] opacity-0').addClass(
                        'translate-y-0 opacity-100');
                    next();
                }).delay(3000).queue(function(next) {
                    $(this).removeClass('translate-y-0 opacity-100').addClass(
                        'translate-y-[-10px] opacity-0');
                    next();
                }).delay(300).queue(function(next) {
                    $(this).remove();
                    next();
                });
            });
        });

        // Trigger refresh with delay
        document.addEventListener('triggerRefreshWithDelay', function() {
            setTimeout(function() {
                @this.call('refreshModulesWithDelay');
            }, 10000); // 3 seconds delay
        });
    </script>
</div>
