@extends('layouts.seller')

@section('title')
    Produk
@endsection

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="tombol d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Products</h1>
        <?php
            $parameter= Crypt::encrypt(Auth::user()->id);
        ?>
        <a href="{{ route('product-seller-create',$parameter) }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i>Tambah Produk
        </a>
    </div>

    <div class="card show mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                                
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $i }}</td><?php $i++ ?>
                                <td><img src="{!! Storage::url($item->galleries->first()->image ?? '') !!}" alt="" style="width: 150px" class="img-thumbnail"></td>
                                <td>{!! $item->name !!}</td>
                                <td>{!! $item->category->name !!}</td>
                                <td>@currency($item->price)</td>
                                <td class="text-center">
                                    <a href="{{ route('product-seller-edit', $item->id) }}" class="btn"> 
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" data-target="#myModal{{$item->id}}" data-toggle="modal" data-url="{{ route('product-seller-destroy', $item->id) }}" class="hapus btn">
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
                                        <form action="{{ route('product-seller-destroy', $item->id) }}" id="deleteForm" method="get" class="d-inline">
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