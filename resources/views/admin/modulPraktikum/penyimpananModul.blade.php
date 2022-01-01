@extends('layouts.app')

@section('title')
    Penyimpanan Modul Praktikum
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/selectric/public/selectric.css') }}">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Penyimpanan Modul Praktikum</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- @error('harga') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    @error('berkas') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror
    @error('praktikum_name') <div class="alert alert-danger" role="alert">{{ $message }}</div> @enderror --}}

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
                        @foreach ($modul as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nama_praktikum }}</td>
                                <td>
                                    <a href="{{ $row->urlberkas }}" target="__blank" class="btn btn-primary">Lihat
                                        File</a>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning mb-2" data-toggle="modal"
                                        data-target="#editBerkas">
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

    <script src="{{ asset('node_modules/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
            var cleaveC = new Cleave('.currency', {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            });
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
                    <h5 class="modal-title" id="newModulLabel">Tambah Modul</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="nama_praktikum" id="media_id" class="form-control select2" style="width: 100%">
                                <option value="" disabled selected>-- Pilih Praktikum --</option>
                                @foreach ($praktikum as $prak)
                                    <option value="{{ $prak->nama . ' ' . $prak->tahun }}">
                                        {{ $prak->nama . ' ' . $prak->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" name="harga_modul" class="form-control currency" id="harga"
                                placeholder="Harga Modul">
                        </div>
                        <div class="form-group">
                            <input type="file" name="file_modul" class="form-control" id="berkasmodul"
                                placeholder="Berkas Modul">
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
