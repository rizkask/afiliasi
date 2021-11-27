@extends('layouts.app')

@section('title')
    Rincian Pesanan
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

            <!-- Tab panes {Fade}  -->
            <div class="tab-content">
                <div class="card card-details">
                  <div class="card-body d-sm-flex justify-content-between" style="color:#a7a7a7;">
                    <a href="{{ url()->previous() }}"><i class="fas fa-chevron-left"></i> Kembali</a>
                    @if($items->transaction_status == 'SUCCESS')
                      @if($items->details->first()->shipping_status == 'SHIPPING' && $items->created_at->diffInHours(\Carbon\Carbon::now()) < 192)
                        <a class="text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">No. Pesanan. {{ $items->code }} | Dikirim</a>
                      @elseif($items->details->first()->shipping_status == 'SHIPPING' && $items->created_at->diffInHours(\Carbon\Carbon::now()) >= 192)
                        <a class="text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">No. Pesanan. {{ $items->code }} | Selesai</a>
                      @elseif($items->details->first()->shipping_status == 'DIKEMAS')
                        <a class="text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">No. Pesanan. {{ $items->code }} | Dikemas</a>
                      @elseif($items->details->first()->shipping_status == 'SUCCESS')
                        <a class="text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">No. Pesanan. {{ $items->code }} | Selesai</a>
                      @elseif($items->details->first()->shipping_status == 'FAILED')
                        <a class="text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">Dibatalkan</a>
                      @endif
                    @elseif($items->transaction_status == 'PENDING' && $items->created_at->diffInHours(\Carbon\Carbon::now()) >= 24)
                      <a class="shopping-cart-wrap text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">Dibatalkan</a>
                    @elseif($items->transaction_status == 'CANCELLED')
                      <a class="shopping-cart-wrap text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">Dibatalkan</a>
                    @else
                      <a class="text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">Belum Bayar</a>
                    @endif

                  </div>
                </div>
                <div class="tab-pane fade in active show" id="about" name="about" role="tabpanel">
                    <div class="card card-details" >
                        <div class="card-body">
                            <div class="row bs-wizard" style="border-bottom:0;">
                    
                                <div class="col-lg-3 bs-wizard-step complete">
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dibuat</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot "></a>
                                  <div class="bs-wizard-info text-center">{{ $items->created_at->addMinutes(421) }}</div>
                                </div>

                                @if($items->transaction_status == 'SUCCESS' && $items->details->first()->shipping_status == 'SHIPPING')
                                <div class="col-lg-3 bs-wizard-step complete"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dibayarkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">{{ $items->bayar_time }}</div>
                                </div>
                                @elseif($items->transaction_status == 'SUCCESS' && $items->details->first()->shipping_status == 'DIKEMAS')
                                <div class="col-lg-3 bs-wizard-step complete"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dibayarkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">{{ $items->updated_at->addMinutes(421) }}</div>
                                </div>
                                @elseif($items->transaction_status == 'SUCCESS' && $items->details->first()->shipping_status == 'SUCCESS')
                                <div class="col-lg-3 bs-wizard-step complete"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dibayarkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">{{ $items->bayar_time }}</div>
                                </div>
                                @else
                                <div class="col-lg-3 bs-wizard-step disabled"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dibayarkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center"></div>
                                </div>
                                @endif
                                
                                @if($items->details->first()->shipping_status == 'SHIPPING' || $items->details->first()->shipping_status == 'SUCCESS')
                                <div class="col-lg-3 bs-wizard-step complete"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dikirimkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">{{ $items->shipping_time }}</div>
                                </div>
                                @else
                                <div class="col-lg-3 bs-wizard-step disabled"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dikirimkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center"></div>
                                </div>
                                @endif
                                
                                @if($items->details->first()->shipping_status == 'SUCCESS')
                                <div class="col-lg-3 bs-wizard-step complete"><!-- active -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Diterima</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">{{ $items->details->first()->updated_at->addMinutes(421) }}</div>
                                </div>
                                @else
                                <div class="col-lg-3 bs-wizard-step disabled"><!-- active -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Diterima</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center"></div>
                                </div>
                                @endif
                                

                            </div>
                            <div class="text-right">
                                <hr>
                                <?php
                                      $beli= Crypt::encrypt($items->id);
                                  ?>
                                @if($items->transaction_status == 'PENDING' && $items->created_at->diffInHours(\Carbon\Carbon::now()) < 24)
                                  <button  name="{{ $items->payment_url }}" onClick="reply_click(this.name)" class="belilagi">Bayar Sekarang</button>
                                  <?php
                                        $id= $items->id;
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
                                @elseif($items->transaction_status == 'FAILED')
                                  <a href="{{ route('belilagi', $beli) }}" class="belilagi">Beli Lagi</a>
                                @elseif($items->transaction_status == 'PENDING' && $items->created_at->diffInHours(\Carbon\Carbon::now()) >= 24)
                                  <a href="{{ route('belilagi', $beli) }}" class="belilagi">Beli Lagi</a>
                                @elseif($items->details->first()->shipping_status == 'SUCCESS')
                                <a href="{{ route('belilagi', $beli) }}" class="belilagi">Beli Lagi</a>
                                <a href="{{ route('faktur',['code'=>$items->code,'id'=>$parameter]) }}" class="variasi">Lihat Faktur</a>
                                @elseif($items->details->first()->shipping_status == 'SHIPPING')
                                  <a href="#" data-target="#modalupdate{{$items->code}}" data-toggle="modal" class="belilagi">Pesanan Diterima</a>
                                  <a href="{{ route('belilagi', $beli) }}" class="belilagi">Beli Lagi</a>
                                @else
                                  <a href="{{ route('belilagi', $beli) }}" class="belilagi">Beli Lagi</a>
                                @endif
                                    <div class="modal fade" id="modalupdate{{$items->code}}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                              <div class="modal-body">
                                                  <form action="{{ route('konfirmasipesanan', ['code'=>$items->details->first()->id,'id'=>$parameter] ) }}" method="post" enctype="multipart/form-data">
                                                      @csrf

                                                      <div class="form-group text-center">
                                                        <h5><b class=" text-center">Konfirmasi Pesanan Diterima</b></h5>
                                                        <h6>Pastikan produk yang diterima sudah sesuai.</h6>
                                                      </div>
                                                      <hr style="margin-left:-15px; margin-right:-15px;">
                                                      <div class="row">
                                                        <div class="col-sm text-center">
                                                          <button type="button" class=" btn " data-dismiss="modal" aria-label="Close">
                                                            Batal
                                                          </button>
                                                        </div>
                                                        <div class="vl" style="margin-top:-16px; margin-bottom:-16px;"></div>
                                                        <div class="col-sm text-center">
                                                          <button type="submit" style="color:rgb(67, 163, 62);" class="btn ">Konfirmasi</button>
                                                        </div>
                                                        
                                                      </div>
                                                      
                                                  </form>

                                              </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-details mb-3">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <b class="text-left">Alamat Pengiriman</b><br>
                        <b>{{$items->user->name}}</b><br>
                        {{$items->user->phone_number}}<br>
                        {{$items->user->address_one}}, {{$items->user->regencies_name}}, {{$items->user->provinces_id}}, {{$items->user->zip_code}}
                        @if($items->details->first()->resi)
                        <br><hr>
                        <b>No. Resi:</b> {{ $items->details->first()->resi }}
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
                @foreach($details as $detail => $value)
                  <div class="card card-details mb-3">
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover tengah" id="dataTable" width="100%" cellspacing="0">
                          <thead class="text-muted">
                              <tr>
                                  <th colspan="2" class="shopping-cart-wrap text-left"><i class="fas fa-calendar"></i> {{ $value->first()->transaction->created_at->addMinutes(421) }}</th>
                                  
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
                                        <div class="row" style="font-size:14px;">
                                          <p>x {{$trans->quantity}}</p>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        @currency($trans->product->price)
                                    </td>
                                </tr>
                              @endforeach
                                <tr >
                                  <?php $total_produk = $value->first()->transaction->total_price - $value->first()->transaction->shipping_price?>
                                  <td colspan="2" class="text-right">Subtotal Produk: <b>@currency($total_produk)</b></td>
                                  
                                </tr>
                                <tr >
                                  <td colspan="2" class="text-right">Ongkos Pengiriman: <b>@currency($value->first()->transaction->shipping_price)</b></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="text-right">Total Pesanan: <b class="harga">@currency($value->first()->transaction->total_price)</b></td>
                                </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                @endforeach
            </div>

            
        </div>
		</div>
        
	</div>
</div>

@endsection

@push('addon-script')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-CjfNfNE4gZUkNvPP"></script>
@endpush