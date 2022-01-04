@extends('layouts.app')

@section('title')
    Penyimpanan Modul Praktikum
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/selectric/public/selectric.css') }}">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
                            <th>Harga Modul</th>
                            <th>PDF Modul</th>
                            <th style="max-width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modul as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nama_praktikum }}</td>
                                <td>Rp. {{ number_format($row->harga, 2, ',', '.') }}</td>
                                <td>
                                    <a href="https://drive.google.com/uc?id={{ $row->id_file }}&export=media"
                                        target="__blank" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat
                                        File</a>
                                </td>
                                <td>
                                    <button class="btn btn-warning" data-toggle="modal"
                                        data-target="#editBerkas{{ $row->id_pmodul }}" type="button">
                                        <span class="icon text-white" data-toggle="tooltip" title="Edit Berkas">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </span>
                                    </button>
                                    <form action="{{ route('admin.penyimpanan-modul.destroy', $row->id_pmodul) }}"
                                        method="POST" class="d-inline" id="form-delete-{{ $row->id_pmodul }}">
                                        @method('delete')
                                        @csrf
                                        <button type="button" class="btn btn-danger"
                                            onclick="hapus({{ $row->id_pmodul }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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

    <script src="{{ asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#nama_praktikumtambah,#nama_praktikumedit')
                .find('option')
                .remove();

            $('#nama_praktikumtambah,#nama_praktikumedit')
                .find('option')
                .end()
                .append(`<option value="" selected disabled> --- Pilih Praktikum ---</option>`)

            $.get(`{{ route('admin.penyimpananModul.getPraktikumJson') }}`, function(data) {
                $.each(data, function(index, row) {
                    $('#nama_praktikumtambah,#nama_praktikumedit')
                        .find('option')
                        .end()
                        .append(
                            `<option value="${row.nama} ${row.tahun}">${row.nama} ${row.tahun}</option>`
                        )
                    // console.log(`"${row.nama} ${row.tahun}"`)
                });
            });
        });

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
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
                            <label for="nama_praktikum"> Nama Praktikum</label>
                            <select name="nama_praktikum" id="nama_praktikumtambah" class="form-control select2"
                                style="width: 100%; height:100%">
                                {{-- <option value="" disabled selected>-- Pilih Praktikum --</option>
                                @foreach ($praktikum as $prak)
                                    <option value="{{ $prak->nama . ' ' . $prak->tahun }}">
                                        {{ $prak->nama . ' ' . $prak->tahun }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga_modul"> Harga Modul</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    Rp
                                </div>
                                <input type="number" name="harga_modul" class="form-control" id="harga"
                                    placeholder="Masukkan Harga Modul">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="file_modul"> File Modul</label>
                            {{-- <input type="file" name="file_modul" class="form-control" id="berkasmodul"
                                placeholder="Berkas Modul"> --}}
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_modul" accept="application/pdf"
                                    name="file_modul">
                                <label class="custom-file-label" for="file_modul">Pilih File</label>
                            </div>
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
    @foreach ($modul as $row)
        <div class="modal fade" id="editBerkas{{ $row->id_pmodul }}" data-backdrop="static" tabindex="-1"
            aria-labelledby="editBerkasLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBerkasLabel">Edit Berkas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.penyimpanan-modul.update', $row->id_pmodul) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_praktikum"> Nama Praktikum</label>
                                <select name="nama_praktikum" id="nama_praktikumedit" class="form-control select2"
                                    style="width: 100%; height:100%">
                                    {{-- <option value="" disabled selected>-- Pilih Praktikum --</option>
                                @foreach ($praktikum as $prak)
                                    <option value="{{ $prak->nama . ' ' . $prak->tahun }}">
                                        {{ $prak->nama . ' ' . $prak->tahun }}</option>
                                @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="harga_modul"> Harga Modul</label>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Rp
                                    </div>
                                    <input type="number" name="harga_modul" class="form-control" id="newharga"
                                        placeholder="Masukkan Harga Modul" value="{{ $row->harga }}">
                                </div>
                            </div>
                            <center>
                                <a href="https://drive.google.com/uc?id={{ $row->id_file }}&export=media"
                                    target="__blank" class="btn btn-primary"><i class="fas fa-eye"></i> Lihat
                                    File Modul Sebelumnya</a>
                            </center>
                            <div class="form-group mt-3">
                                <label for="file_modul"> File Modul Baru</label>
                                {{-- <input type="file" name="file_modul" class="form-control" id="berkasmodul"
                                placeholder="Berkas Modul"> --}}
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="newfile_modul" accept="application/pdf"
                                        name="file_modul">
                                    <label class="custom-file-label" for="file_modul">Pilih File</label>
                                </div>
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
    @endforeach

    <!-- endmodal -->
@endpush
