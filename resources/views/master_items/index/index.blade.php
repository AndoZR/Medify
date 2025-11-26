@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Row Tombol Aksi -->
            <div class="d-flex justify-content-between mb-3">

                <!-- Tambah Data -->
                <a href="{{ url('master-items/form/new') }}" class="btn btn-secondary">
                    + Master Item Baru
                </a>

                <!-- Export Excel -->
                <a href="{{ url('master-items/export/excel') }}" class="btn btn-success">
                    Export Excel
                </a>

            </div>

            <div class="card">

                <div class="card-header">Daftar Master Items</div>

                <div class="card-body">
                    @include('master_items.index.filter')
                    @include('master_items.index.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@include('master_items.index.js')
@endsection