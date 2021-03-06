<!-- Nav Item - Dashboard -->
<li class="nav-item">
    @if (auth()->user()->role == 0)
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
        @elseif (auth()->user()->role == 1)
            <a class="nav-link" href="{{ route('praktikan.dashboard') }}">
    @endif
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Menu
</div>

@if (auth()->user()->role == 1)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('praktikan.berkas-praktikum.index') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Berkas Praktikum</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('praktikan.modul') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Modul Praktikum</span></a>
    </li>
@elseif (auth()->user()->role == 0)
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book"></i>
            <span>Modul Praktikum</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Menu Modul :</h6> --}}
                <a class="collapse-item" href="{{ route('admin.penyimpanan-modul.index') }}">Penyimpanan Modul</a>
                <a class="collapse-item" href="{{ route('admin.jadwal-modul.index') }}">Jadwal Pembelian</a>
                <a class="collapse-item" href="{{ route('admin.verifikasiModul.view') }}">Verif Pembelian Modul</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
            aria-controls="collapseOne">
            <i class="fa fa-fw fa-file"></i>
            <span>Berkas Praktikum</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Menu Modul :</h6> --}}
                <a class="collapse-item" href="{{ route('admin.penyimpananBerkas.index') }}">Penyimpanan Berkas</a>
                <a class="collapse-item" href="{{ route('admin.verifikasiBerkas.view') }}">Verif Berkas</a>
            </div>
        </div>
    </li>
@endif
