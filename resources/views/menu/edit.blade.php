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
            Edit Menu {{ $data->id_menu }}
        </div>
        <div class="card-body">
            <form action="{{ route('menu_simpan_edit_data', $data->id_menu) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama_menu">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="{{ $data->nama_menu }}">
                </div>
                <div class="form-group">
                    <label for="harga_menu">Harga Menu</label>
                    <input type="number" class="form-control" id="harga_menu" name="harga_menu" value="{{ $data->harga_menu }}">
                </div>
                <div class="form-group">
                    <label for="gambar_menu">Gambar Menu</label>
                    <input type="file" class="form-control" id="gambar_menu" name="gambar_menu">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection