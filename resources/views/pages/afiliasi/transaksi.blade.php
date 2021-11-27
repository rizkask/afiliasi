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
                                        <h6>Total Pemasukan</h6>
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
                        <a class="nav-link " href="{{ route('afiliasi', $parameter) }}">Produk Afiliasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Transaksi</a>
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
                                    <h6 class="mb-0 text-gray-800">Total komisi yang sedang diajukan: @currency($ajukan)</h6>
                                    <a href="#" data-target="#modalupdate" data-toggle="modal" class="btn btn-sm btn-success shadow-sm">
                                        <i class="fas fa-plus fa-sm text-white-50"></i> Ajukan Komisi
                                    </a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Waktu Transaksi</th>
                                                <th>Pembeli</th>
                                                <th>Produk</th>
                                                <th>Komisi</th>
                                                <th>Status Pengajuan</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1;
                                                $total=0;  
                                                $y=$detail->where('claims_id',NULL);
                                                foreach($y as $p){
                                                    $total += $p->komisi; 
                                                }
                                            ?>
                                                    
                                            @forelse($detail as $item)
                                                <tr><?php $i++ ?>
                                                    <td>{{ $item->created_at->addMinutes(421) }}</td>
                                                    <td>{{ $item->transaction->user->name }}</td>
                                                    <td>{!! $item->product->name !!}</td>
                                                    <td>@currency($item->komisi)</td>
                                                    <td class="text-center">{!! $item->ref_status_label !!}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        Data Kosong
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal fade" id="modalupdate" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ajukan Komisi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('claim',$parameter) }}" method="post" enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group">
                                                <label for="claim">Total Komisi yang akan di claim</label>
                                                <input type="text" name="claim" value="@currency($total)" required class="form-control" disabled>
                                                </div>

                                                <button type="submit" class="btn btn-primary float-right">Kirim</button>
                                            </form>

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

@endpush