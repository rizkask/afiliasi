@extends('layouts.admin')

@section('title')
    Produk
@endsection

@section('content')

<div class="container-fluid">

    <div class="tombol d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">All Products</h1>
        <?php
            $parameter= Crypt::encrypt(Auth::user()->id);
        ?>
        <a href="{{ route('product.create',$parameter) }}" class="btn btn-sm btn-primary shadow-sm">
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
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Komisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                                
                        @forelse($items as $item)
                            <tr>
                                <td class="text-center">{{ $i }}.</td><?php $i++ ?>
                                <td><img src="{!! Storage::url($item->galleries->first()->image ?? '') !!}" alt="" class="foto-produk mr-3"> {!! $item->name !!}</td>
                                <td>{!! $item->category->name !!}</td>
                                <td>@currency($item->price)</td>
                                @if($item->affiliate == 1)
                                <td>@currency($item->komisi)</td>
                                @else
                                <td>-</td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('product.edit', $item->id) }}" class="btn"> 
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" data-target="#myModal{{$item->id}}" data-toggle="modal" data-url="{{ route('product.destroy', $item->id) }}" class="hapus btn">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @if($item->affiliate == 1)
                                    <a href="{{ route('off-affiliate',$item->id) }}" class="btn btn-sm btn-secondary shadow-sm" style="font-size:14px;"> 
                                        <i class="fas fa-minus fa-sm"></i> Afiliasi
                                    </a>
                                    @else
                                    <a href="#" data-target="#modalupdate{{$item->id}}" data-toggle="modal" class="btn btn-sm btn-success shadow-sm" style="font-size:14px;"> 
                                        <i class="fas fa-plus fa-sm"></i> Afiliasi
                                    </a>
                                    @endif
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
                                        <form action="{{ route('product.destroy', $item->id) }}" id="deleteForm" method="post" class="d-inline">
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
                            <div class="modal fade" id="modalupdate{{$item->id}}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                                <div class="modal-dialog .modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Komisi Produk Afiliasi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">

                                        <form action="{{ route('on-affiliate',$item->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label for="komisi">Komisi</label>
                                                <input name="komisi" required class="form-control" type="text">
                                            </div>

                                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                        </form>

                                        </div>
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