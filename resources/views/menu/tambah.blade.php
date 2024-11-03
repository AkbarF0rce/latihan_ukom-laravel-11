@extends('layout.navbarAndSidebar')

@section('title', 'Create Menu')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            Tambah Menu
        </div>
        <div class="card-body">
            <form action="{{ route('menu_simpan_tambah_data') }}" method="post" enctype="multipart/form-data" id="addMenu">
                @csrf
                <div class="form-group">
                    <label for="id_menu">Id Menu</label>
                    <input type="number" class="form-control" id="id_menu" name="id_menu" value="{{ old('id_menu') }}">
                </div>
                <div class="form-group">
                    <label for="nama_menu">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ old('nama_menu') }}">
                </div>
                <div class="form-group">
                    <label for="harga_menu">Harga Menu</label>
                    <input type="number" class="form-control" id="harga_menu" name="harga_menu" value="{{ old('harga_menu') }}">
                </div>
                <div class="form-group">
                    <label for="gambar_menu">Gambar Menu</label>
                    <input type="file" class="form-control" id="gambar_menu" name="gambar_menu">
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex gap-2 justify-content-end">
                <button type="submit" class="btn btn-primary" form="addMenu">Submit</button>
                <a href="{{ route('menu_index') }}" class="btn btn-danger">Back</a>
            </div>
        </div>
    </div>
@endsection