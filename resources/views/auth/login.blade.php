@extends('auth.layouts.layout')

@section('auth_content')
    <div class="flex md:flex-row flex-col h-screen justify-between">
        <div class="md:w-1/2 lg:order-1 order-2 h-full flex flex-col md:justify-center relative p-2 lg:p-5">
            @livewire('login-component')
        </div>
        <div class="md:w-1/2 max-h-40 md:max-h-[unset] order-1 lg:order-2 p-2 lg:p-5 relative">
            <div
                class="bg-gradient-to-br from-primary-700 to-primary-200  overflow-hidden w-full h-full rounded-xl relative flex justify-center items-center">
                <div id="lottie-login" class="w-2/3 object-cover"></div>
                <div id="lottie-component"
                    class="w-1/4 object-cover absolute top-52 left-24 -rotate-12 hover:scale-105 transition-all ease-in-out hidden lg:flex">
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var animation = lottie.loadAnimation({
            container: document.getElementById('lottie-login'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/images/lottie/login.json') }}' // Ganti dengan path file Lottie JSON kamu
        });
        var animation2 = lottie.loadAnimation({
            container: document.getElementById('lottie-component'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/images/lottie/code.json') }}' // Ganti dengan path file Lottie JSON lainnya
        });
        // var animation3 = lottie.loadAnimation({
        //     container: document.getElementById('lottie-3'),
        //     renderer: 'svg',
        //     loop: true,
        //     autoplay: true,
        //     path: '{{ asset('assets/images/lottie/live-code.json') }}' // Ganti dengan path file Lottie JSON lainnya
        // });
    </script>
@endpush
