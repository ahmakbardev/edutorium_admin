@extends('layouts.layout')

@section('content')
    <div class="mx-6 my-10 grid grid-cols-1 xl:grid-cols-3 grid-rows-1 grid-flow-row-dense gap-6">
        <div class="">
            <div class="card h-full shadow">
                <div class="border-b border-gray-300 px-5 py-4 flex items-center w-full justify-between">
                    <div>
                        <h4 class="font-semibold text-base">Tambah Banner Baru</h4>
                    </div>
                </div>

                <div class="container mx-auto py-8 px-5">
                    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700">Nama Banner</label>
                            <input type="text" id="name" name="name"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Gambar Banner</label>
                            <input type="file" id="image" name="image"
                                class="block w-full mt-1 p-2 border border-gray-300 rounded" accept="image/png" required>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 w-full text-white rounded">Simpan
                            Banner</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
