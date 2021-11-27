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
                        <a class="nav-link" href="{{ route('transaksi-afiliasi', $parameter) }}">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Komisi Masuk</a>
                    </li>
                </ul>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card fade show">
                            <div class="card-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Waktu Pengajuan</th>
                                            <th>Total Komisi</th>
                                            <th>Bukti Transfer</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1;
                                        ?>
                                                
                                        @forelse($detail as $item)
                                                    
                                            @if($item->bukti == NULL)
                                                <tr>
                                                    <?php 
                                                        $claim = claim::where('id', $item->claims_id)->get();
                                                    ?>
                                                    <td>{{ $claim->first()->created_at->addMinutes(421) }}</td>
                                                    <td>{{ $claim->first()->total_claim }}</td>
                                                    <td>
                                                        Belum Tersedia
                                                    </td>
                                                    <td>
                                                        Unconfirmed
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <?php 
                                                        $cek = bukti::where('id', $item->bukti)->get(); 
                                                        $claim = claim::where('id', $cek->first()->claim_id)->get();
                                                    ?>
                                                    <td>{{ $claim->first()->created_at }}</td>
                                                    <td>{{ $claim->first()->total_claim }}</td>
                                                    <td>
                                                        <a href="{{ Storage::url($cek->first()->image) }}" class="href" >
                                                                Lihat Bukti
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($cek->first()->confirm == 1)
                                                            <span class="badge badge-secondary">Confirmed</span>
                                                        @else
                                                            <a href="{{ route('confirm',['id'=>$parameter,'code'=>$cek->first()->id]) }}" > 
                                                                <span class="badge badge-success">Confirm</span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            
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