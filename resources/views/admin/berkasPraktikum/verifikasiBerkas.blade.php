@extends('layouts.app')

@section('title')
    Verifikasi Berkas Praktikum
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Verifikasi Berkas Praktikum</h1>

    <div class="mb-3">
        <button class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newBerkas">
            <span class="icon text-white-50">
                <i class="fas fa-download"></i>
            </span>
            <span class="text">Export Excel</span>
        </button>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Verifikasi Modul Pemrograman Terstruktur 2021</h6>
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
                            <th style="max-width: 300px;">Aksi</th>
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
                                        <div class="badge badge-pill badge-warning"
                                            style="min-width: 100px; font-size:15px">
                                            Belum Disetujui
                                        </div>
                                    @elseif ($row->status == 1)
                                        <div class="badge badge-pill badge-success"
                                            style="min-width: 100px; font-size:15px">
                                            Disetujui
                                        </div>
                                    @elseif ($row->status == 2)
                                        <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">
                                            Berkas Ditolak
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status == 0)
                                        <form
                                            action="{{ route('admin.verifikasiBerkas.verifikasi', $row->id_berkasPrak) }}"
                                            method="POST" class="d-inline"
                                            id="form-verif-{{ $row->id_berkasPrak }}">
                                            @csrf
                                            <button type="button" class="btn btn-success btn-sm mb-2"
                                                onclick="verif({{ $row->id_berkasPrak }})">
                                                <span class="icon text-white">
                                                    Verifikasi
                                                </span>
                                            </button>
                                        </form>
                                        {{-- <a href="{{ route('admin.verifikasiBerkas.verifikasi', $row->id_berkasPrak) }}"
                                            class="btn btn-sm btn-success mb-2" onclick="verif()">
                                            <span class="icon text-white">
                                                Verifikasi
                                            </span>
                                        </a> --}}
                                        <button class="btn btn-sm btn-danger mb-2" data-toggle="modal"
                                            data-target="#tolakVerifikasi{{ $row->id_berkasPrak }}">
                                            <span class="icon text-white">
                                                Tolak
                                            </span>
                                        </button>
                                    @elseif ($row->status == 1 || $row->status == 2)
                                        <center>
                                            -
                                        </center>
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

@push('modal')
    <!-- Modal tambah Aplikasi-->
    @foreach ($berkas as $row)
        <div class="modal fade" id="tolakVerifikasi{{ $row->id_berkasPrak }}" data-backdrop="static" tabindex="-1"
            aria-labelledby="tolakLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tolakLabel">Tolak Verifikasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.verifikasiBerkas.tolak', $row->id_berkasPrak) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <span>Alasan Ditolak</span>
                            <textarea name="alasan" id="" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" onclick="kirim()" class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    <!-- endmodal -->
@endpush
