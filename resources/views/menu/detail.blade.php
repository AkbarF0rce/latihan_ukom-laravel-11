@extends('layout.navbarAndSidebar')

@section('title', 'Detail Menu')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Detail Menu {{ $data->nama_menu }}</h1>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center gap-4 m-3">
                @if ($data->gambar_menu !== null)
                    <img src="{{ asset('storage/menu/' . $data->gambar_menu) }}" alt="" class="w-25 h-50 shadow-sm shadow-gray-200">
                @endif
                <div>
                    <p>Id Menu: {{ $data->id_menu }}</p>
                    <p>Nama Menu: {{ $data->nama_menu }}</p>
                    <p>Harga: {{ $data->harga_menu }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="{{ route('menu_index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
@endsection