@extends('layouts.seller')

@section('title')
    Produk
@endsection

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="tombol d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">My Affiliate Products</h1>
        <?php
            $parameter= Crypt::encrypt(Auth::user()->id);
        ?>
        <a href="#" data-target="#modalupdate" data-toggle="modal" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Afiliasi
        </a>
    </div>

    <div class="card show mb-4">
        <nav>
            <div class="nav nav-tabs nav-fill" id="nav-tab">
            <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);" href="{{ route('my-product-aff', $parameter) }}">Produk Afiliasi Saya</a>
            <a class="nav-item nav-link " style="color: rgb(141, 141, 141);"  href="{{ route('afiliator', $parameter) }}">Afiliator</a>
            <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('afiliator-trans', $parameter) }}">Transaksi</a>
            </div>
        </nav>
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
                            <th>Komisi</th>
                            <th>Afiliator</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                                
                        @forelse($product as $item)
                            <tr>
                                <td>{{ $i }}</td><?php $i++ ?>
                                <td><img src="{!! Storage::url($item->galleries->first()->image ?? '') !!}" alt="" style="width: 150px" class="img-thumbnail"></td>
                                <td>{!! $item->name !!}</td>
                                <td>{!! $item->category->name !!}</td>
                                <td>@currency($item->price)</td>
                                <td>@currency($item->komisi)</td>
                                <?php
                                    $cek = affiliate::where('products_id',$item->id)->get();
                                ?>
                                <td>{{ $cek->count() }}</td>
                                <td>    
                                    <a href="{{ route('off-affiliate',$item->id) }}" style="font-size:14px; color:red;"> 
                                        <i class="fas fa-minus fa-sm"></i> Off Afiliasi
                                    </a>
                                </td>
                            </tr>
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

    <div class="modal fade" id="modalupdate" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Daftar Produk Afiliasi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form action="{{ route('on-affiliate',$parameter) }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                      <label for="product">Produk Saya</label>
                      <select name="product" required class="form-control">
                          @foreach($all as $p)
                              <option value="{{ $p->id }}">{{ $p->name }}</option>
                          @endforeach
                      </select>
                  </div>

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

</div>

@endsection