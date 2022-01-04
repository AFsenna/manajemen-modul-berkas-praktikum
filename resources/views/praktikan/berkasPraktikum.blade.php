@extends('layouts.app')

@section('title')
    Berkas Praktikum
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/selectric/public/selectric.css') }}">
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
                        @foreach ($berkasPrak as $row)
                            <tr>
                                <td>1</td>
                                <td style="max-width: 200px">{{ $row->nama_praktikum }}</td>
                                <td>
                                    <img src="https://drive.google.com/uc?export=view&id={{ $row->idKwitansi }}"
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
                                        <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">
                                            Belum Disetujui
                                        </div>
                                    @elseif ($row->status == 1)
                                        <div class="badge badge-pill badge-success"
                                            style="min-width: 100px; font-size:15px">
                                            Disetujui
                                        </div>
                                    @elseif ($row->status == 2)
                                        <div class="badge badge-pill badge-warning"
                                            style="min-width: 100px; font-size:15px">
                                            BerkasDitolak
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($row->status == 1)
                                        <center>
                                            -
                                        </center>
                                    @else
                                        <button class="btn btn-warning" data-toggle="modal"
                                            data-target="#editBerkas{{ $row->id_berkasPrak }}" type="button">
                                            <span class="icon text-white" data-toggle="tooltip" title="Edit Berkas">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </span>
                                        </button>
                                        <form
                                            action="{{ route('praktikan.berkas-praktikum.destroy', $row->id_berkasPrak) }}"
                                            method="POST" class="d-inline"
                                            id="form-delete-{{ $row->id_berkasPrak }}">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-danger"
                                                onclick="hapus({{ $row->id_berkasPrak }})">
                                                <i class="fas fa-trash"></i>
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
    <script src="{{ asset('node_modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('node_modules/selectric/public/jquery.selectric.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#nama_praktikumtambah')
                .find('option')
                .remove();

            $('#nama_praktikumtambah')
                .find('option')
                .end()
                .append(`<option value="" selected disabled> --- Pilih Praktikum ---</option>`)

            $.get(`{{ route('praktikan.berkasPraktikum.getPraktikumJson') }}`, function(data) {
                $.each(data, function(index, row) {
                    $('#nama_praktikumtambah')
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
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_praktikum"> Nama Praktikum</label>
                            <select name="nama_praktikum" id="nama_praktikumtambah" class="form-control select2"
                                style="width: 100%; height:100%">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="scan_kwiansi"> Scan Kwitansi</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="scan_kwitansi"
                                    accept="image/x-png, image/jpeg" name="scan_kwitansi">
                                <label class="custom-file-label" for="scan_kwiansi">Masukkan file gambar</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pdf_pendaftaran"> PDF Pendaftaran</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="pdf_pendaftaran" accept="application/pdf"
                                    name="pdf_pendaftaran">
                                <label class="custom-file-label" for="pdf_pendaftaran">Masukkan file PDF Pendaftaran</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pdf_krs"> PDF KRS</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="pdf_krs" name="pdf_krs"
                                    accept="application/pdf">
                                <label class="custom-file-label" for="pdf_krs">Masukkan file PDF KRS</label>
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
                            <label for="scan_kwiansi"> Scan Kwitansi</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="scan_kwitansi"
                                    accept="image/x-png, image/jpeg" name="scan_kwitansi">
                                <label class="custom-file-label" for="scan_kwiansi">Masukkan file gambar</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pdf_pendaftaran"> PDF Pendaftaran</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="pdf_pendaftaran" accept="application/pdf"
                                    name="pdf_pendaftaran">
                                <label class="custom-file-label" for="pdf_pendaftaran">Masukkan file PDF Pendaftaran</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pdf_krs"> PDF KRS</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="pdf_krs" name="pdf_krs"
                                    accept="application/pdf">
                                <label class="custom-file-label" for="pdf_krs">Masukkan file PDF KRS</label>
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
    <!-- endmodal -->
@endpush
