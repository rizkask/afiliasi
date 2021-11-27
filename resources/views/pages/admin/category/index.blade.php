@extends('layouts.admin')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="tombol d-sm-flex align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kategori</h1>
    </div>
    

    <div class="row">
        <div class="col-lg-6">
            <div class="card show mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1 ?>
                                        
                                @forelse($items as $item)
                                    <tr>
                                        <td class="text-center" width="10%">{{ $i }}.</td><?php $i++ ?>
                                        <td width="60%">{!! $item->name !!}</td>
                                        <td class="text-center" width="30%">
                                            <a href="{{ route('category.edit', $item->id) }}" class="btn btn-outline-info btn-round"> 
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <a href="#" data-target="#myModal{{$item->id}}" data-toggle="modal" data-url="{{ route('category.destroy', $item->id) }}" class="hapus btn btn-outline-danger btn-round">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <div id="myModal{{$item->id}}" class="modal fade myModal">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- dialog body -->
                                                <div class="modal-body">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    Apakah Anda yakin ingin menghapus data ini?
                                                </div>
                                                <!-- dialog buttons -->
                                                <form action="{{ route('category.destroy', $item->id) }}" id="deleteForm" method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Hapus</button>
                                                        
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Data Kosong
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tambah Kategori</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama Kategori" value="" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Tambah
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</div>

@endsection