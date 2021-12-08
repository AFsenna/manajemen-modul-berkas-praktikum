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
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('praktikan.berkasPrak') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Berkas Praktikum</span></a>
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
                <a class="collapse-item" href="/penyimpanan-modul">Penyimpanan Modul</a>
                <a class="collapse-item" href="{{ route('admin.pembelianModul') }}">Jadwal Pembelian</a>
                <a class="collapse-item" href="{{ route('admin.verifikasiModul') }}">Verif Pembelian Modul</a>
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
                <a class="collapse-item" href="{{ route('admin.penyimpananBerkas') }}">Penyimpanan Berkas</a>
                <a class="collapse-item" href="{{ route('admin.verifikasiBerkas') }}">Verif Berkas</a>
            </div>
        </div>
    </li>
@endif
