@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10">
        <div class="card h-full shadow">
            <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                <div>
                    <h4 class="font-semibold text-base">Banner</h4>
                </div>
                <button class="btn bg-blue-600 text-white px-4 py-2 rounded" onclick="openModal()">Tambah Banner</button>
            </div>

            <div class="container mx-auto py-8 px-5">
                <div class="relative overflow-x-auto overflow-y-auto max-h-[458px]" data-simplebar="">
                    <table class="text-left w-full whitespace-nowrap">
                        <thead class="text-gray-700 sticky top-0">
                            <tr>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Nama</th>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Gambar</th>
                                <th scope="col" class="border-b bg-gray-100 px-6 py-3 cursor-default">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bannerTableBody">
                            @foreach ($banners as $banner)
                                <tr class="hover:bg-slate-100 transition-all ease-in-out" id="bannerRow{{ $banner->id }}">
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left cursor-pointer"
                                        onclick="viewBanner('{{ asset('storage/' . $banner->image) }}')">{{ $banner->name }}
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left cursor-pointer"
                                        onclick="viewBanner('{{ asset('storage/' . $banner->image) }}')">
                                        <img src="{{ asset('storage/' . $banner->image) }}" class="w-16 h-16 object-cover"
                                            alt="{{ $banner->name }}">
                                    </td>
                                    <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                                        <button class="btn bg-yellow-500 text-white px-4 py-2 rounded"
                                            onclick="openEditModal({{ $banner->id }}, '{{ $banner->name }}', '{{ asset('storage/' . $banner->image) }}')">Edit</button>
                                        <button class="btn bg-red-600 text-white px-4 py-2 rounded"
                                            onclick="deleteBanner({{ $banner->id }})">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="bannerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg transform translate-y-10 opacity-0 transition duration-300"
            id="modalContent">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold text-lg" id="modalTitle">Tambah Banner</h4>
                    <button
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center"
                        onclick="closeModal()">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close menu</span>
                    </button>
                </div>
                <form id="bannerForm">
                    @csrf
                    <input type="hidden" id="bannerId" name="banner_id">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700">Nama Banner</label>
                        <input type="text" id="name" name="name"
                            class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">Gambar Banner</label>
                        <input type="file" id="image" name="image"
                            class="block w-full mt-1 p-2 border border-gray-300 rounded" accept="image/png">
                        <img id="previewImage" class="w-16 h-16 mt-2 hidden" alt="Preview Image">
                    </div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 w-full text-white rounded">Simpan Banner</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Banner -->
    <div id="viewBannerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg transform translate-y-10 opacity-0 transition duration-300"
            id="viewModalContent">
            <div class="p-6 w-full max-w-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold text-lg">Preview Banner</h4>
                    <button
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center"
                        onclick="closeViewModal()">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close menu</span>
                    </button>
                </div>
                <img id="viewBannerImage" src="" class="w-full h-auto" alt="Banner Image">
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        const storageUrl = "{{ asset('storage/') }}";

        function openModal() {
            $('#bannerModal').removeClass('hidden');
            setTimeout(() => {
                $('#modalContent').removeClass('translate-y-10 opacity-0');
            }, 100);
        }

        function closeModal() {
            $('#modalContent').addClass('translate-y-10 opacity-0');
            setTimeout(() => {
                $('#bannerModal').addClass('hidden');
                $('#bannerForm')[0].reset();
                $('#bannerId').val('');
                $('#modalTitle').text('Tambah Banner');
                $('#previewImage').addClass('hidden');
            }, 300);
        }

        function openEditModal(id, name, imageUrl) {
            $('#bannerModal').removeClass('hidden');
            setTimeout(() => {
                $('#modalContent').removeClass('translate-y-10 opacity-0');
            }, 100);
            $('#bannerId').val(id);
            $('#name').val(name);
            $('#modalTitle').text('Edit Banner');
            $('#previewImage').attr('src', imageUrl).removeClass('hidden');
        }

        function closeViewModal() {
            $('#viewModalContent').addClass('translate-y-10 opacity-0');
            setTimeout(() => {
                $('#viewBannerModal').addClass('hidden');
            }, 300);
        }

        function viewBanner(imageUrl) {
            $('#viewBannerModal').removeClass('hidden');
            setTimeout(() => {
                $('#viewModalContent').removeClass('translate-y-10 opacity-0');
            }, 100);
            $('#viewBannerImage').attr('src', imageUrl);
        }

        $('#bannerForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let bannerId = $('#bannerId').val();
            let url = bannerId ? `/banners/${bannerId}` : "{{ route('banners.store') }}";
            let method = bannerId ? 'POST' : 'POST';

            if (bannerId) {
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: url,
                method: method,
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    closeModal();
                    updateBannerTable(response.banner);
                    showToast('success', response.success);
                },
                error: function(response) {
                    showToast('error', response.responseJSON.message);
                }
            });
        });

        function deleteBanner(id) {
            if (confirm('Apakah anda yakin ingin menghapus banner ini?')) {
                $.ajax({
                    url: `/banners/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $(`#bannerRow${id}`).remove();
                        showToast('success', response.success);
                    },
                    error: function(response) {
                        showToast('error', response.responseJSON.message);
                    }
                });
            }
        }

        function updateBannerTable(banner) {
            let imageUrl = `${storageUrl}/${banner.image}`;
            let rowHtml = `
        <tr class="hover:bg-slate-100 transition-all ease-in-out" id="bannerRow${banner.id}">
            <td class="border-b border-gray-300 font-medium py-3 px-6 text-left cursor-pointer" onclick="viewBanner('${imageUrl}')">${banner.name}</td>
            <td class="border-b border-gray-300 font-medium py-3 px-6 text-left cursor-pointer" onclick="viewBanner('${imageUrl}')">
                <img src="${imageUrl}" class="w-16 h-16 object-cover" alt="${banner.name}">
            </td>
            <td class="border-b border-gray-300 font-medium py-3 px-6 text-left">
                <button class="btn bg-yellow-500 text-white px-4 py-2 rounded" onclick="openEditModal(${banner.id}, '${banner.name}', '${imageUrl}')">Edit</button>
                <button class="btn bg-red-600 text-white px-4 py-2 rounded" onclick="deleteBanner(${banner.id})">Hapus</button>
            </td>
        </tr>
    `;

            if ($(`#bannerRow${banner.id}`).length) {
                $(`#bannerRow${banner.id}`).replaceWith(rowHtml);
            } else {
                $('#bannerTableBody').append(rowHtml);
            }
        }

        function showToast(type, message) {
            let toastHtml = `
        <div class="own-toast bg-${type === 'success' ? 'green' : 'red'}-100 border-l-4 border-${type === 'success' ? 'green' : 'red'}-500 text-${type === 'success' ? 'green' : 'red'}-700 p-4 mb-4 shadow-lg rounded transform transition-transform duration-300 translate-y-[-10px] opacity-0">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="text-sm">${message}</p>
                </div>
            </div>
        </div>
    `;

            $('#toast-container').append(toastHtml);
            $('.own-toast').last().delay(300).queue(function(next) {
                $(this).removeClass('translate-y-[-10px] opacity-0').addClass('translate-y-0 opacity-100');
                next();
            }).delay(3000).queue(function(next) {
                $(this).removeClass('translate-y-0 opacity-100').addClass('translate-y-[-10px] opacity-0');
                next();
            }).delay(300).queue(function(next) {
                $(this).remove();
                next();
            });
        }
    </script>
@endsection
