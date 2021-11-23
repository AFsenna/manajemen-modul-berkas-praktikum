@extends('layouts.app')

@section('title')
    Verifikasi Modul
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Verifikasi Modul</h1>

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
                        <tr>
                            <td>1</td>
                            <td>Alexandria Felicia Seanne</td>
                            <td>06.2019.1.07103</td>
                            <td>
                                <div class="badge badge-pill badge-success" style="min-width: 100px; font-size:15px">
                                    Lunas
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-danger mb-2">
                                    Batalkan
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modal')

@endpush