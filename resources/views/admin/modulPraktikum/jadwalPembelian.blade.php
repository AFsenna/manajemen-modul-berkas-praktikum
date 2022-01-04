@extends('layouts.app')

@section('title')
    Jadwal Pembelian Modul
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/selectric/public/selectric.css') }}">
    <style>
        table,
        th,
        td {
            /* border: 1px solid black; */
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

    </style>
@endpush
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Jadwal Pembelian Modul</h1>

    <div class="mb-3">
        <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#newModul">
            <span class="icon text-white-50">
                <i class="fas fa-edit"></i>
            </span>
            <span class="text">Atur Jadwal</span>
        </button>
        <button class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#editModul">
            <span class="icon text-white-50">
                <i class="fas fa-pencil-alt"></i>
            </span>
            <span class="text">Ubah Jadwal</span>
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            {{-- <h6 class="m-0 font-weight-bold text-primary">Jadwal Pembelian Modul Basis Data 2021</h6> --}}
        </div>
        <div class="card-body">
            {{-- <div class="text-center bg-danger text-light">
                Jadwal Pembelian Modul Belum Diatur!
            </div> --}}
            <center>
                <div class="card-header bg-primary" style="width:70%;">
                    <h6 class="font-weight-bold text-light">Jadwal Pembelian Modul Basis Data 2021</h6>
                </div>
                <div class="card" style="width:70%;">
                    <table style="width:100%;">
                        <tr>
                            <th>Koordinator Modul</th>
                            <th>:</th>
                            <td>Alexandria Felicia Seanne</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <th>:</th>
                            <td>082285132960</td>
                        </tr>
                        <tr>
                            <th>Lokasi Pembelian</th>
                            <th>:</th>
                            <td>Gedung H Didepan Ruang Jurusan Informatika ITATS</td>
                        </tr>
                        <tr>
                            <th>Waktu Pembelian</th>
                            <th>:</th>
                            <td>22 November 2021 13:00 PM</td>
                        </tr>
                    </table>
                </div>
            </center>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
@push('modal')
    <!-- Modal tambah Aplikasi-->
    <div class="modal fade" id="newModul" data-backdrop="static" tabindex="-1" aria-labelledby="newModulLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newModulLabel">Atur Jadwal Pembelian Modul</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Koordinator Modul</label>
                            <select name="media_id" id="media_id" class="form-control select2"
                                style="width: 100%; height:100%">
                                <option value="" disabled selected>-- Pilih Koordinator Modul --</option>
                                <option value="1">Alexandria Felicia Seanne</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Pembelian</label>
                            <input type="text" name="berkas" class="form-control" id="berkas"
                                placeholder="Masukkan Lokasi">
                        </div>
                        <div class="form-group">
                            <label>Waktu Pembelian</label>
                            <input type="datetime-local" name="waktu" class="form-control" id="waktu">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- endmodal -->

    <!-- Modal edit Aplikasi-->
    <div class="modal fade" id="editModul" data-backdrop="static" tabindex="-1" aria-labelledby="editModulLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModulLabel">Edit Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Koordinator Modul</label>
                            <select name="media_id" id="media_id" class="form-control select2"
                                style="width: 100%; height:100%">
                                <option value="" disabled selected>-- Pilih Koordinator Modul --</option>
                                <option value="1">Alexandria Felicia Seanne</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Pembelian</label>
                            <input type="text" name="berkas" class="form-control" id="berkas"
                                placeholder="Masukkan Lokasi">
                        </div>
                        <div class="form-group">
                            <label>Waktu Pembelian</label>
                            <input type="datetime-local" name="waktu" class="form-control" id="waktu">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- endmodal -->
@endpush
