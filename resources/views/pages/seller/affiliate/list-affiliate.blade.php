@extends('layouts.seller')

@section('title')
    Tambah Produk
@endsection

@section('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <?php
            $parameter= Crypt::encrypt(Auth::user()->id);
        ?>
        <h1 class="h3 mb-0 text-gray-800">Rekomendasi Saya</h1>
        <a href="{{ route('pilih-affiliate',$parameter) }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Rekomendasi
        </a>
    </div>

        <!-- Content Row -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card show mb-4">
            <nav>
              <div class="nav nav-tabs nav-fill" id="nav-tab">
                  <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);" href="{{ route('list-affiliate', $parameter) }}">Produk Rekomendasi Saya</a>
                  <a class="nav-item nav-link " style="color: rgb(141, 141, 141);"  href="{{ route('affiliate-transaction', $parameter) }}">Transaksi</a>
              </div>
            </nav>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Product Name</th>
                                <th>Toko</th>
                                <th>Komisi</th>
                                <th>Link</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1 ?>
                                    
                            @forelse($affs as $aff)
                                <tr>
                                    <td>{{ $i }}</td><?php $i++ ?>
                                    <td>{!! $aff->product->name !!}</td>
                                    <td>{!! $aff->product->user->store_name !!}</td>
                                    <td>{!! $aff->product->komisi !!}</td>
                                    <td>
                                        @if($aff->product->affiliate==1)
                                        <input type="text" 
                                        value="{{ url('/product/ref/' . Auth::user()->id . '/' . $aff->product->id) }}" 
                                        readonly class="form-control">
                                        @else
                                        <input type="text" 
                                        value="Off Affiliate" 
                                        readonly class="form-control">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('delete-aff', $aff->id) }}" class="hapus btn btn-round">
                                            <i style="color: #747474;" class="fa fa-trash"></i>
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
        <!--modal-->
        
    </div>
    <!-- /.container-fluid -->

    
@endsection

@push('addon-script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#category-img-tag').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#cat_image").change(function(){
            readURL(this);
        });
    </script>
@endpush