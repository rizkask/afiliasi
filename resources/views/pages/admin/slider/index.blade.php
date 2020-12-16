@extends('layouts.admin')

@section('title')
    Slider
@endsection

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="tombol d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Banner</h1>
        <a href="{{ route('slider.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>Tambah Banner
        </a>
    </div>
    <!-- Content Row -->
    <div class="card show mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10">No.</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i=1 ?>
                        @forelse($items as $item)
                        <tr>
                            <td>{{ $i }}</td><?php $i++ ?>
                            <td><img src="{!! Storage::url($item->image) !!}" alt="" style="width: 150px" class="img-thumbnail"></td>
                            <td class="text-center">
                                <a href="#" data-target="#myModal{{$item->id}}" data-toggle="modal" data-url="{{ route('slider.destroy', $item->id) }}" class="hapus btn btn-outline-danger btn-round">
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
                <form action="{{ route('slider.destroy', $item->id) }}" id="deleteForm" method="post" class="d-inline">
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
@endsection