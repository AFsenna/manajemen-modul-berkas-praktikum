@extends('layouts.app')

@section('title')
    Pilih Praktikum
@endsection


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
            <form action="{{ route('admin.penyimpananBerkas') }}" method="POST">
                @csrf
                <div class="body">
                    <div class="form-group">
                        <select name="media_id" id="media_id" class="form-control">
                            <option value="" disabled selected>-- Pilih Praktikum --</option>
                            <option value="1">Basis Data 2021</option>
                            <option value="2">Basis Data 2020</option>
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
