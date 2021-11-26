@extends('layouts.app')

@section('title')
    Penyimpanan Modul Praktikum
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Penyimpanan Modul Praktikum</h1>

    <div class="mb-3">
        <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#newModul">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Modul</span>
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Penyimpanan Modul Praktikum</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Praktikum</th>
                            <th>PDF Modul</th>
                            <th style="max-width: 300px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Pemrograman Terstruktur 2020</td>
                            <td>
                                <a href="https://drive.google.com/file/d/1-yrBnyASNaGT0KblKPe8R2gFNB74nKK0/view?usp=sharing"
                                    target="__blank" class="btn btn-primary">Lihat File</a>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning mb-2" data-toggle="modal" data-target="#editBerkas">
                                    <span class="icon text-white" data-toggle="tooltip" title="Edit Berkas">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </span>
                                </button>
                                <a href="#" class="btn btn-sm btn-danger mb-2" data-toggle="tooltip" title="Hapus Berkas">
                                    <span class="icon text-white">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </span>
                                </a>
                            </td>
                        </tr>
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
    <div class="modal fade" id="newModul" data-backdrop="static" tabindex="-1" aria-labelledby="newModulLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newModulLabel">Tambah Modul</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="media_id" id="media_id" class="form-control">
                                <option value="" disabled selected>-- Pilih Praktikum --</option>
                                <option value="1">Basis Data 2021</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="number" name="berkas" class="form-control" id="berkas" placeholder="Harga Modul">
                        </div>
                        <div class="form-group">
                            <input type="file" name="berkas" class="form-control" id="berkas" placeholder="Nama Aplikasi">
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
    <div class="modal fade" id="editBerkas" data-backdrop="static" tabindex="-1" aria-labelledby="editBerkasLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBerkasLabel">Edit Berkas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="number" name="berkas" class="form-control" id="berkas" placeholder="Harga Modul">
                        </div>
                        <div class="form-group">
                            <span>PDF Modul</span>
                            <input type="file" name="aplikasi" class="form-control" placeholder="Nama Aplikasi" value="">
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
