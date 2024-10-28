<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dasbor</span>
            </a>
        </li>
        <li class="nav-item nav-category">Verifikasi</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#verifikasi" aria-expanded="false"
                aria-controls="verifikasi">
                <i class="menu-icon mdi mdi-account-multiple-outline"></i>
                <span class="menu-title">Anggota</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="verifikasi">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link"
                            href="{{ route('verifikator.permohonan.index') }}">Dosen</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="menu-icon mdi mdi mdi-file"></i>
                <span class="menu-title">Tunjangan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('verifikator.pengajuan.index') }}">Data
                            Pengajuan</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Anggota</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#dosen" aria-expanded="false" aria-controls="dosen">
                <i class="menu-icon mdi mdi-account"></i>
                <span class="menu-title">Dosen</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="dosen">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Data Dosen</a>
                        {{-- route beda untuk pageview beda yang ada filter universitas --}}
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pendaftaran Dosen</a>
                        {{-- route beda untuk pageview beda yang ada filter universitas --}}
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Profil</li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#profil" aria-expanded="false" aria-controls="profil">
                <i class="menu-icon mdi mdi-account-card-details"></i>
                <span class="menu-title">Profil</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="profil">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="{{ route('profil') }}">Lihat Profil</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">FAQ</a></li> --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('setelan') }}">Setelan</a></li>
                    {{-- <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">Keluar
                            (popup warning)</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> --}}
                </ul>
            </div>
        </li>
        <li class="nav-item nav-category">Lainnya</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('faq_view') }}">
                <i class="mdi mdi-help-circle-outline menu-icon"></i>
                <span class="menu-title">FAQ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick=    "event.preventDefault();
                        document.getElementById('logout-form').submit();">
                <i class="mdi mdi mdi-power menu-icon"></i>
                <span class="menu-title">Keluar
                    (popup warning)</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>
