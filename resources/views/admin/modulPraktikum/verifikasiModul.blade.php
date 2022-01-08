@extends('layouts.app')

@section('title')
    Verifikasi Pembelian Modul
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Verifikasi Pembelian Modul</h1>

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
                                    @if ($row->statusModul == 1)
                                        <div class="badge badge-pill badge-success" style="min-width: 100px; font-size:15px">
                                            Lunas
                                        </div>
                                    @else
                                        <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">
                                            Belum Dibeli
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->statusModul == 1)
                                        <form action="{{ route('admin.verifikasiModul.batalkan', $row->id_berkasPrak) }}"
                                            method="POST" class="d-inline" id="form-undo-{{ $row->id_berkasPrak }}">
                                            @csrf
                                            <button type="button" class="btn btn-danger btn-sm mb-2"
                                                onclick="batalkan({{ $row->id_berkasPrak }})">
                                                <span class="icon text-white">
                                                    Batalkan
                                                </span>
                                            </button>
                                        </form>
                                    @else
                                        <form
                                            action="{{ route('admin.verifikasiModul.verifikasi', $row->id_berkasPrak) }}"
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

@endpush
