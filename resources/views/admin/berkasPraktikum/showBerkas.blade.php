@extends('layouts.app')

@section('title')
    Penyimpanan Berkas
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800 mb-3">
        <a href="{{ route('admin.penyimpananBerkas.index') }}"><i class="fas fa-arrow-left mr-2"></i></a>
        Penyimpanan Berkas Praktikum
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Berkas Praktikum
                {{ $praktikumAktif[0]->nama . ' ' . $praktikumAktif[0]->tahun }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NPM</th>
                            <th>Foto kwitansi
                                <span class="btn info" data-toggle="tooltip"
                                    title="Arahkan kursor ke arah gambar agar dapat terlihat lebih jelas"><i
                                        class="fa fa-info-circle"></i></span>
                            </th>
                            <th>PDF Pendaftaran</th>
                            <th>PDF KRS</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($berkas as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->users->name }}</td>
                                <td>{{ $row->users->credential }}</td>
                                <td>
                                    <img class="kwitansi"
                                        src="https://drive.google.com/uc?export=view&id={{ $row->idKwitansi }}"
                                        width="200px" height="100px" alt="">
                                </td>
                                <td>
                                    <a href="https://drive.google.com/uc?id={{ $row->idPendaftaran }}&export=media"
                                        target="__blank" class="btn btn-info" data-toggle="tooltip" title="Lihat File"><i
                                            class="fa fa-eye"></i></a>
                                </td>
                                <td>
                                    <a href="https://drive.google.com/uc?id={{ $row->idKRS }}&export=media"
                                        target="__blank" class="btn btn-primary" data-toggle="tooltip" title="Lihat File"><i
                                            class="fa fa-eye"></i></a>
                                </td>
                                <td>
                                    @if ($row->status == 0)
                                        <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">
                                            Belum Disetujui
                                        </div>
                                    @elseif ($row->status == 1)
                                        <div class="badge badge-pill badge-success"
                                            style="min-width: 100px; font-size:15px">
                                            Disetujui
                                        </div>
                                    @elseif ($row->status == 2)
                                        <div class="badge badge-pill badge-warning"
                                            style="min-width: 100px; font-size:15px">
                                            BerkasDitolak
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
