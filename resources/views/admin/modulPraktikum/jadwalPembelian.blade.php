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
        @if ($jadwal == null)
            <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#newModul">
                <span class="icon text-white-50">
                    <i class="fas fa-edit"></i>
                </span>
                <span class="text">Atur Jadwal</span>
            </button>
        @else
            <button class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#editModul">
                <span class="icon text-white-50">
                    <i class="fas fa-pencil-alt"></i>
                </span>
                <span class="text">Ubah Jadwal</span>
            </button>
        @endif
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
                    <h6 class="font-weight-bold text-light">Jadwal Pembelian Modul
                        {{ $praktikumAktif[0]->nama . ' ' . $praktikumAktif[0]->tahun }}</h6>
                </div>
                <div class="card" style="width:70%;">
                    <table style="width:100%;">
                        <tr>
                            <th>Koordinator Modul</th>
                            <th>:</th>
                            <td>{{ $aslab == null ? 'Belum Diatur' : $aslab[0]->nama }}</td>
                        </tr>
                        <tr>
                            <th>Nomor Telepon</th>
                            <th>:</th>
                            <td>{{ $aslab == null ? 'Belum Diatur' : $aslab[0]->no_tlpn }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi Pembelian</th>
                            <th>:</th>
                            <td>{{ $jadwal == null ? 'Belum Diatur' : $jadwal->lokasiPembelian }}</td>
                        </tr>
                        <tr>
                            <th>Waktu Pembelian</th>
                            <th>:</th>
                            <td>{{ $jadwal == null ? 'Belum Diatur' : $jadwal->waktuPembelian }}</td>
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
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="idPraktikum" value="{{ $praktikumAktif[0]->id }}">
                        <div class="form-group">
                            <label>Koordinator Modul</label>
                            <select name="koordinator" id="koordinator" class="form-control select2"
                                style="width: 100%; height:100%">
                                <option value="" disabled selected>-- Pilih Koordinator Modul --</option>
                                @foreach ($aslabAktif as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama . ' (' . $row->username . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Pembelian</label>
                            <textarea name="lokasi" id="lokasi" cols="50" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Waktu Pembelian</label>
                            <input type="datetime-local" name="waktu" class="form-control" id="waktu" required>
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
                <form action="{{ route('admin.jadwalModul.update', $jadwal == null ? 0 : $jadwal->id_jadwal) }}"
                    method="POST">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <input type="hidden" name="idPraktikum" value="{{ $praktikumAktif[0]->id }}">
                        <div class="form-group">
                            <label>Koordinator Modul</label>
                            <select name="koordinator" id="media_idnew" class="form-control select2"
                                style="width: 100%; height:100%">
                                <option value="" disabled selected>-- Pilih Koordinator Modul --</option>
                                @foreach ($aslabAktif as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $row->id == $jadwal->idAslab ? 'selected' : '' }}>
                                        {{ $row->nama . ' (' . $row->username . ')' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Pembelian</label>
                            <textarea name="lokasi" id="lokasi" cols="50" rows="3"
                                required>{{ $jadwal == null ? 'Belum Diatur' : $jadwal->lokasiPembelian }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Waktu Pembelian (kosongi jika tidak ingin diganti)</label>
                            <input type="datetime-local" name="waktu" class="form-control" id="waktunew"
                                value="{{ $jadwal == null ? 'Belum Diatur' : $jadwal->waktuPembelian }}">
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
