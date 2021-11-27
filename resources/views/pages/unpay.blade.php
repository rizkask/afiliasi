@extends('layouts.app')

@section('title')
    Pesanan Belum Dibayar
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
              <a href="{{ route('pesanan-saya', $parameter) }}" style="font-size: 14px; color:rgb(67, 163, 62);" class="list-group-item list-group-item-action">Pesanan Saya</a>
              <a href="{{ route('afiliasi', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Afiliasi</a>
          </div> 
		</div>
		<div class="col-md-10">
        <div id="navbar-example">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('pesanan-saya', $parameter) }}" >Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('unpay', $parameter) }}">Belum Bayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dikemas', $parameter) }}">Dikemas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sent', $parameter) }}" >Dikirim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('done', $parameter) }}" >Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cancel', $parameter) }}" >Dibatalkan</a>
                </li>
            </ul>

            <!-- Tab panes {Fade}  -->
            <div class="tab-content">
                <div class="tab-pane fade in active show pesanan-saya" id="about" name="about" role="tabpanel">
                    
                      @if($items->count()==0)
                      <div class="card card-details" >
                        <p class="empty">Belum Ada Pesanan</p>
                      </div>
                      @else
                        @foreach($items as $item => $value)
                        <div class="card card-details mb-3">
                          <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-hover tengah" id="dataTable" width="100%" cellspacing="0">
                                <thead class="text-muted">
                                  <tr class="text-left">
                                      <!--<th scope="col">
                                          <label>
                                              <input type="checkbox" name="select-all" id="select-all" />
                                          </label>
                                      </th>-->
                                      <th class="shopping-cart-wrap text-left"><i class="fas fa-calendar"></i> {{ $value->first()->transaction->created_at->addMinutes(421) }}</th>
                                      <th class="shopping-cart-wrap text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">Belum Bayar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($value as $trans)
                                      <tr class="shopping-cart-wrap">
                                          <td>
                                              <div class="produk-cart pull-left mr-3">
                                                  <a href="{{ route('detail', $trans->product->slug) }}">
                                                      <img src="{{ url($trans->product->galleries->count() ? Storage::url($trans->product->galleries->first()->image) : '') }}" alt="...">
                                                  </a>
                                              </div>
                                              <div class="row">
                                                  <a href="{{ route('detail', $trans->product->slug) }}">{{ $trans->product->name }}</a>
                                              </div>
                                          </td>
                                          <td class="text-right">
                                              @currency($trans->product->price)
                                          </td>
                                      </tr>
                                    
                                    @endforeach
                                    <tr>
                                          <td class="text-left pojok"><br><br>Bayar sebelum <b style="color: rgb(67, 163, 62);"><i class="fa fa-clock"></i> {{ $value->first()->transaction->created_at->addMinutes(1861) }}</b></td>
                                          <td class="text-right">Jumlah Harus Dibayar: <b class="harga">@currency($value->first()->transaction->total_price)</b>
                                          <br>
                                          <button  name="{{ $value->first()->transaction->payment_url }}" onClick="reply_click(this.name)" class="belilagi">Bayar Sekarang</button>
                                          <a href="{{ route('rincian-pesanan', ['code'=>$value->first()->transaction->code,'id'=>$parameter]) }}" class="variasi">Rincian Pesanan</a></td>
                                          <?php
                                                $id= $value->first()->transaction->id;
                                                echo "<script type='text/javascript'>
                                                var get = function(){
                                                      var get = $id;
                                                      return get;
                                                  }();

                                                function reply_click(clicked_id)
                                                {
                                                  snap.pay(clicked_id);
                                                }
                                                
                                                </script>";
                                          ?>
                                    </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                        @endforeach
                      @endif
                </div>
            </div>
        </div>
		</div>
        
	</div>
</div>

@endsection

@push('addon-script')
  <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-CjfNfNE4gZUkNvPP"></script>
@endpush