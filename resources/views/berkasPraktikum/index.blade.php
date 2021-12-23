@extends('layouts.app')

@section('title')
    Berkas Praktikum
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Berkas Praktikum</h1>

    <div class="mb-3">
        <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#newBerkas">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Berkas</span>
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Berkas Praktikum</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Praktikum</th>
                            <th>Foto kwitansi</th>
                            <th>PDF Pendaftaran</th>
                            <th>PDF KRS</th>
                            <th>Status</th>
                            <th style="max-width: 300px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td style="max-width: 200px">Pemrograman Terstruktur 2020</td>
                            <td>
                                <img src="{{ asset('img/contohkwitansi.jpg') }}" width="200px" height="100px" alt="">
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1iy-iXFnrRQlbn9CzWYPeALHeKHR_BfAS/view?usp=sharing"
                                    target="__blank" class="btn btn-info" data-toggle="tooltip" title="Lihat File"><i
                                        class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1jF3qYe2dMOpqsi8UhnqyDaC2S7tdK_s_/view?usp=sharing"
                                    target="__blank" class="btn btn-primary" data-toggle="tooltip" title="Lihat File"><i
                                        class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                <div class="badge badge-pill badge-success" style="min-width: 100px; font-size:15px">
                                    Disetujui
                                </div>
                            </td>
                            <td>
                                <center>
                                    -
                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td style="max-width: 200px">Pemrograman Berorientasi Objek 2021</td>
                            <td>
                                <img src="{{ asset('img/contohkwitansi.jpg') }}" width="200px" height="100px" alt="">
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1iy-iXFnrRQlbn9CzWYPeALHeKHR_BfAS/view?usp=sharing"
                                    target="__blank" class="btn btn-info" data-toggle="tooltip" title="Lihat File"><i
                                        class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1jF3qYe2dMOpqsi8UhnqyDaC2S7tdK_s_/view?usp=sharing"
                                    target="__blank" class="btn btn-primary" data-toggle="tooltip" title="Lihat File"><i
                                        class="fa fa-eye"></i></a>
                            </td>
                            <td>
                                <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">
                                    Belum Disetujui
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning mb-2" data-toggle="modal" data-target="#editBerkas">
                                    <span class="icon text-white" data-toggle="tooltip" title="Edit Berkas">
                                        <i class="fas fa-fw fa-edit"></i>
                                    </span>
                                </button>
                                <a href="#" class="btn btn-sm btn-danger mb-2" onclick="hapus()" data-toggle="tooltip"
                                    title="Hapus Berkas">
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

@push('modal')
    <!-- Modal tambah Aplikasi-->
    <div class="modal fade" id="newBerkas" data-backdrop="static" tabindex="-1" aria-labelledby="newBerkasLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newBerkasLabel">Tambah Berkas</h5>
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
                            <input type="text" name="berkas" class="form-control" id="berkas" placeholder="Nama Aplikasi">
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
                            <span>Scan Kwitansi</span>
                            <input type="file" name="aplikasi" class="form-control" placeholder="Gambar " value="">
                        </div>
                        <div class="form-group">
                            <span>PDF Pendaftaran</span>
                            <input type="file" name="aplikasi" class="form-control" placeholder="Nama Aplikasi" value="">
                        </div>
                        <div class="form-group">
                            <span>PDF KRS</span>
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

@push('js')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endpush
