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
        <a href="{{ route('aslab.penyimpananBerkas') }}"><i class="fas fa-arrow-left mr-2"></i></a>
        Penyimpanan Berkas Praktikum
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Berkas Praktikum Basis Data 2021</h6>
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
                            <th>Status</th>
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
