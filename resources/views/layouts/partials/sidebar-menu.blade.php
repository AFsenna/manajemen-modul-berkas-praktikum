<!-- Nav Item - Dashboard -->
<li class="nav-item">
    <a class="nav-link" href="index.html">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Menu
</div>

<!-- Nav Item - Pages Collapse Menu -->
{{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Components</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
        </div>
    </div>
</li> --}}

@if (auth()->guard('mahasiswa')->user()->role_id == 2)
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('praktikan.berkasPrak') }}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Berkas Praktikum</span></a>
    </li>
@elseif (auth()->guard('mahasiswa')->user()->role_id == 1)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('aslab.penyimpananModul') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Penyimpanan Modul</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('aslab.verifikasiModul') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Verifikasi Modul</span></a>
    </li>
@endif
