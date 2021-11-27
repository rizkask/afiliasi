@extends('layouts.app')

@section('title')
    Afiliasi
@endsection

@section('content')
<br>
<!------ Include the above in your HEAD tag ---------->
<div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
          
	<div class="row">
		<div class="col-md-2 ">
		      <div class="list-group ">
              <?php
                  $parameter= Crypt::encrypt(Auth::user()->id);
              ?>
              <a href="{{ route('profil', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Akun Saya</a>
              <a href="{{ route('pass', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Ubah Password</a>
              <a href="{{ route('pesanan-saya', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Pesanan Saya</a>
              <a href="{{ route('afiliasi', $parameter) }}" style="font-size: 14px; color:rgb(67, 163, 62);" class="list-group-item list-group-item-action">Afiliasi</a>
          </div> 
		</div>
		<div class="col-md-10">
            <div id="navbar-example">
            
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="card fade show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <h6>Total Komisi</h6>
                                        <h3>@currency($revenue)</h3>
                                    </div>
                                    <div class="vl"></div>
                                    <div class="col-sm">
                                        <h6>Total Transaksi</h6>
                                        <h3>{{ $jml }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Produk Afiliasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transaksi-afiliasi', $parameter) }}">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pengajuan', $parameter) }}">Komisi Masuk</a>
                    </li>
                </ul>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card fade show">
                            <div class="card-body">
                                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                    <h6 class="mb-0 text-gray-800"></h6>
                                    <a href="#" data-target="#modalupdate" data-toggle="modal" class="btn btn-sm btn-success shadow-sm">
                                        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Produk Afiliasi
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr style="font-size:13px;">
                                                <th class="text-center">No.</th>
                                                <th>Nama Produk</th>
                                                <th>Komisi</th>
                                                <th>Transaksi</th>
                                                <th>Link Afiliasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1 ?>
                                                    
                                            @forelse($product as $aff)
                                                <tr>
                                                    <td class="text-center">{{ $i }}.</td><?php $i++ ?>
                                                    <td><img src="{!! Storage::url($aff->product->galleries->first()->image ?? '') !!}" alt="" class="foto-produk mr-3">{!! $aff->product->name !!}</td>
                                                    <td style="vertical-align: middle; font-size:14px;">@currency($aff->product->komisi)</td>
                                                    <?php $perproduk = TransactionDetail::where('ref',Auth::user()->id)->where('products_id', $aff->product->id)
                                                                                            ->whereHas('transaction', function($transaction){
                                                                                                $transaction->where('transaction_status','SUCCESS');
                                                                                            })->count(); ?>
                                                    <td class="text-center" style="vertical-align: middle; font-size:14px;">{{ $perproduk }}</td>
                                                    <td style="vertical-align: middle;">
                                                        @if($aff->product->affiliate==1)
                                                        <div class="input-group input-group-sm">
                                                            
                                                            <input type="text" value="{{ url('/product/ref/' . Auth::user()->id . '/' . $aff->product->id) }}"  id="{{ $aff->id }}"
                                                            readonly class="form-control" aria-label="Small" >
                                                            <div class="input-group-append">
                                                                <button class="input-group-text" onclick="copyToClipboard('{{$aff->id}}')"><i class="fas fa-copy fa-sm "></i></button>
                                                            </div>
                                                        </div>
                                                        @else
                                                            <input type="text" 
                                                            value="Tidak Tersedia" 
                                                            readonly class="form-control">
                                                        @endif
                                                        
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('delete-aff', ['code' => $aff->id, 'id' => $parameter]) }}" class="hapus btn btn-round">
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
                                <div class="modal fade" id="modalupdate" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Produk Afiliasi</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row col-md-12 siti">
                                                    @forelse($items as $item)
                                                        <?php
                                                            $cek = affiliate::where('products_id', $item->id)->where('users_id', Auth::user()->id)->first();
                                                        ?>
                                                        @if($cek == null)
                                                            <div class="col-md-6 mb-3">
                                                                <div class="card fade show">
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="ml-3">
                                                                                    <img src="{!! Storage::url($item->galleries->first()->image ?? '') !!}" alt="" class="tita img-thumbnail">
                                                                            </div> 
                                                                            <div class="col-sm">
                                                                                <h6>{{ $item->name}} </h6>
                                                                                <h6>@currency($item->price)</h6>
                                                                                <h6>Komisi: <b>@currency($item->komisi)</b></h6>
                                                                                
                                                                                <h6><a href="{{ route('add-affiliate',['id'=>$parameter,'code'=>$item->id]) }}" style="font-size:14px;"> 
                                                                                    <i class="fas fa-plus fa-sm"></i> Tambah ke Produk Afiliasi
                                                                                </a><h6>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>

<!-- End Modal UPDATE Barang-->
        
	</div>
</div>

@endsection

@push('addon-script')
  <script src="https://unpkg.com/vue-toasted"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-CjfNfNE4gZUkNvPP"></script>
<script>
    function copyToClipboard(id) {
        var copyText = document.getElementById(id);
        navigator.clipboard.writeText(copyText.value);
    }
</script>

@endpush