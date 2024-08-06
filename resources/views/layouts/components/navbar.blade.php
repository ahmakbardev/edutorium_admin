<nav class="navbar-vertical navbar">
    <div id="myScrollableElement" class="h-screen" data-simplebar>
        <!-- brand logo -->
        <a class="navbar-brand flex gap-3 items-center" href="/">
            <p class="font-bold text-xl text-white w-fit">Edutorium</p>
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
                <a class="nav-link collapsed {{ request()->routeIs('livecode_assessments.*', 'tugas_akhir_assessments.*') ? 'active' : '' }}"
                    href="#!" data-bs-toggle="collapse" data-bs-target="#penilaian"
                    aria-expanded="{{ request()->routeIs('livecode_assessments.*', 'tugas_akhir_assessments.*') ? 'true' : 'false' }}"
                    aria-controls="penilaian">
                    <i data-feather="edit-3" class="w-4 h-4 mr-2"></i>
                    Penilaian
                </a>
                <div id="penilaian"
                    class="collapse {{ request()->routeIs('livecode_assessments.*', 'tugas_akhir_assessments.*') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-col">
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('livecode_assessments.index') ? 'active' : '' }}"
                                href="{{ route('livecode_assessments.index') }}">
                                <i data-feather="code" class="w-4 h-4 mr-2"></i>
                                LiveCode
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link flex gap-1 {{ request()->routeIs('tugas_akhir_assessments.index') ? 'active' : '' }}"
                                href="{{ route('tugas_akhir_assessments.index') }}">
                                <i data-feather="star" class="w-4 h-4 mr-2"></i>
                                Tugas Akhir
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- nav item -->
            <li class="nav-item">
                <div class="navbar-heading">Additional Features</div>
            </li>

            <!-- nav item -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('banners.*') ? 'active' : '' }}"
                    href="{{ route('banners.index') }}">
                    <i data-feather="tv" class="w-4 h-4 mr-2"></i>
                    Banner
                </a>
            </li>

        </ul>
    </div>
</nav>
