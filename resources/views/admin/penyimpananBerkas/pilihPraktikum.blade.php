@extends('layouts.app')

@section('title')
    Pilih Praktikum
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/selectric/public/selectric.css') }}">
@endpush

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 text-gray-800 mb-3">
        Penyimpanan Berkas
    </h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Silahkan Pilih Praktikum Dahulu</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.penyimpananBerkas.store') }}" method="POST">
                @csrf
                <div class="body">
                    <div class="form-group">
                        <select name="idPraktikum" id="idPraktikum" class="form-control select2"
                            style="width: 100%; height:100%">
                            <option value="" disabled selected>-- Pilih Praktikum --</option>
                            @foreach ($praktikum as $row)
                                <option value="{{ $row->id }}">{{ $row->nama . ' ' . $row->tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn btn-primary">Lanjut</button>
                </div>
            </form>
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
