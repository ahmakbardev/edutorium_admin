<nav class="navbar-vertical navbar">
    <div id="myScrollableElement" class="h-screen" data-simplebar>
        <!-- brand logo -->
        <a class="navbar-brand" href="./index.html">
            <img src="{{ asset('assets/images/brand/logo/logo.svg') }}" alt="" />
        </a>

        <!-- navbar nav -->
        <ul class="navbar-nav flex-col" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i data-feather="home" class="w-4 h-4 mr-2"></i>
                    Dashboard
                </a>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <div class="navbar-heading">FEATURES</div>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link collapsed {{ request()->routeIs('modul', 'materi.*', 'livecode_tutorials.*', 'quizzes.*', 'tugasAkhir.*') ? 'active' : '' }}"
                    href="#!" data-bs-toggle="collapse" data-bs-target="#bootcamp"
                    aria-expanded="{{ request()->routeIs('modul', 'materi.*', 'livecode_tutorials.*', 'quizzes.*', 'tugasAkhir.*') ? 'true' : 'false' }}"
                    aria-controls="bootcamp">
                    <i data-feather="zap" class="w-4 h-4 mr-2"></i>
                    Bootcamp
                </a>
                <div id="bootcamp"
                    class="collapse {{ request()->routeIs('modul', 'materi.*', 'livecode_tutorials.*', 'quizzes.*', 'tugasAkhir.*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('modul') ? 'active' : '' }}"
                                href="{{ route('modul') }}">
                                <i data-feather="columns" class="w-4 h-4 mr-2"></i>
                                Modul
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('materi.index') ? 'active' : '' }}"
                                href="{{ route('materi.index') }}">
                                <i data-feather="file-text" class="w-4 h-4 mr-2"></i>
                                Materi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('livecode_tutorials.index') ? 'active' : '' }}"
                                href="{{ route('livecode_tutorials.index') }}">
                                <i data-feather="code" class="w-4 h-4 mr-2"></i>
                                LiveCode
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('quizzes.index') ? 'active' : '' }}"
                                href="{{ route('quizzes.index') }}">
                                <i data-feather="edit-2" class="w-4 h-4 mr-2"></i>
                                Quiz
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('tugasAkhir.index') ? 'active' : '' }}"
                                href="{{ route('tugasAkhir.index') }}">
                                <i data-feather="star" class="w-4 h-4 mr-2"></i>
                                Tugas Akhir
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link collapsed {{ request()->routeIs('penilaian.*') ? 'active' : '' }}" href="#!"
                    data-bs-toggle="collapse" data-bs-target="#penilaian"
                    aria-expanded="{{ request()->routeIs('penilaian.*') ? 'true' : 'false' }}"
                    aria-controls="penilaian">
                    <i data-feather="edit-3" class="w-4 h-4 mr-2"></i>
                    Penilaian
                </a>
                <div id="penilaian" class="collapse {{ request()->routeIs('penilaian.*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('penilaian.livecode') ? 'active' : '' }}"
                                href="#">
                                <i data-feather="code" class="w-4 h-4 mr-2"></i>
                                LiveCode
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('penilaian.tugasakhir') ? 'active' : '' }}"
                                href="#">
                                <i data-feather="star" class="w-4 h-4 mr-2"></i>
                                Tugas Akhir
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Akun</div>
            </li>

            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.profile.index') ? 'active' : '' }}" href="#">
                    <i data-feather="user" class="w-4 h-4 mr-2"></i>
                    Profil
                </a>
            </li>
        </ul>
    </div>
</nav>
