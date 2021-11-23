@extends('layouts.app')

@section('title')
    Verifikasi Berkas Praktikum
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Verifikasi Berkas Praktikum</h1>

    <div class="mb-3">
        <button class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#newBerkas">
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
                            <th>Foto kwitansi</th>
                            <th>PDF Pendaftaran</th>
                            <th>PDF KRS</th>
                            <th style="max-width: 300px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Alexandria Felicia Seanne</td>
                            <td>06.2019.1.07103</td>
                            <td>
                                <img src="{{ asset('img/contohkwitansi.jpg') }}" width="200px" height="100px" alt="">
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1iy-iXFnrRQlbn9CzWYPeALHeKHR_BfAS/view?usp=sharing"
                                    target="__blank" class="btn btn-info">Lihat File</a>
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1jF3qYe2dMOpqsi8UhnqyDaC2S7tdK_s_/view?usp=sharing"
                                    target="__blank" class="btn btn-primary">Lihat File</a>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#">
                                    <span class="icon text-white" data-toggle="tooltip" title="Edit Berkas">
                                        Verifikasi
                                    </span>
                                </button>
                                <button class="btn btn-sm btn-danger mb-2" data-toggle="modal"
                                    data-target="#tolakVerifikasi">
                                    <span class="icon text-white">
                                        Tolak
                                    </span>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Alexandria Felicia Seanne</td>
                            <td>06.2019.1.07103</td>
                            <td>
                                <img src="{{ asset('img/contohkwitansi.jpg') }}" width="200px" height="100px" alt="">
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1iy-iXFnrRQlbn9CzWYPeALHeKHR_BfAS/view?usp=sharing"
                                    target="__blank" class="btn btn-info">Lihat File</a>
                            </td>
                            <td>
                                <a href="https://drive.google.com/file/d/1jF3qYe2dMOpqsi8UhnqyDaC2S7tdK_s_/view?usp=sharing"
                                    target="__blank" class="btn btn-primary">Lihat File</a>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-success mb-2" data-toggle="modal" data-target="#">
                                    <span class="icon text-white" data-toggle="tooltip" title="Edit Berkas">
                                        Verifikasi
                                    </span>
                                </button>
                                <button class="btn btn-sm btn-danger mb-2" data-toggle="modal"
                                    data-target="#tolakVerifikasi">
                                    <span class="icon text-white">
                                        Tolak
                                    </span>
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
    <!-- Modal tambah Aplikasi-->
    <div class="modal fade" id="tolakVerifikasi" data-backdrop="static" tabindex="-1" aria-labelledby="tolakLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tolakLabel">Tolak Verifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    <div class="modal-body">
                        <span>Alasan Ditolak</span>
                        <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
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
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- endmodal -->
@endpush
