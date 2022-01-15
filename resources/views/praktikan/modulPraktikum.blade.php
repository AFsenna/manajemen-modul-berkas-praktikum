@extends('layouts.app')

@section('title')
    Modul Praktikum
@endsection

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800">Modul Praktikum</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Modul Praktikum</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Praktikum</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($berkas as $key => $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $praktikum[$key]->nama . ' ' . $praktikum[$key]->tahun }}</td>
                                <td>
                                    @if ($row->statusModul == 1)
                                        <div class="badge badge-pill badge-success" style="min-width: 100px; font-size:15px">
                                            Lunas
                                        </div>
                                    @else
                                        <div class="badge badge-pill badge-danger" style="min-width: 100px; font-size:15px">
                                            Belum Dibeli
                                        </div>
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
@endpush
@push('modal')

@endpush
