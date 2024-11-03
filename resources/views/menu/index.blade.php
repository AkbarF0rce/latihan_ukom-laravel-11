@extends('layout.navbarAndSidebar')

@section('title', 'List Menu')

@section('page-title', 'Welcome to the List Menu')

@section('content')
    <p>This is the list menu page content.</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="text-primary">Daftar Menu</span>
            <div class="d-flex gap-2">
                <a class="btn btn-primary" href="{{ route('menu_tambah_data') }}">Tambah</a>
                <button type="button" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger">Delete</button>
                <button type="button" data-toggle="modal" data-target="#editModal" class="btn btn-warning">Edit</button>
                <button type="button" data-toggle="modal" data-target="#detailModal" class="btn btn-warning">Detail</button>
            </div>
        </div>
        <div class="card-body">
            <div>
                <table id="menuTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id Menu</th>
                            <th>Nama Menu</th>
                            <th>Harga Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $menu)
                            <tr>
                                <td class="align-middle">{{ $menu->id_menu }}</td>
                                <td class="align-middle">{{ $menu->nama_menu }}</td>
                                <td class="align-middle">{{ $menu->harga_menu }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('menu_hapus_data') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="form-group">
                            <label for="id_menu">Id Menu</label>
                            <input type="number" class="form-control" id="id_menu" name="id_menu">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search Id Menu to Edit</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('menu_edit_data') }}">
                        <div class="form-group">
                            <label for="id_menu">Id Menu</label>
                            <input type="number" class="form-control" id="id_menu" name="id_menu">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Search Id Menu to Details</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('menu_detail_data') }}">
                        <div class="form-group">
                            <label for="id_menu">Id Menu</label>
                            <input type="number" class="form-control" id="id_menu" name="id_menu">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteMenu(id) {
            if (confirm("Apakah Anda yakin ingin menghapus menu ini?")) {
                axios.delete(`/menu/hapusData/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.data.status === 'success') {
                        alert(response.data.message);
                        location.reload();
                    } else {
                        alert(response.data.message);
                    }
                });
            }
        }
    </script>
@endsection
