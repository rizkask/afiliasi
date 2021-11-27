@extends('layouts.app')

@section('title')
    Pesanan Dikirim
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
                    <a class="nav-link" href="{{ route('unpay', $parameter) }}">Belum Bayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dikemas', $parameter) }}">Dikemas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('sent', $parameter) }}" >Dikirim</a>
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
                                      <th class="shopping-cart-wrap text-right" style="color: rgb(67, 163, 62); font-weight:inherit;">Dikirim</th>
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
                                    <tr class="text-right">
                                          <td class="text-left pojok"><br><br>Konfirmasi terima produk sebelum <b style="color: rgb(67, 163, 62);"><i class="fa fa-clock"></i> {{ $value->first()->transaction->updated_at->addMinutes(11941) }}</b></td>
                                          <td colspan="text-left">Total Pesanan: <b class="harga">@currency($value->first()->transaction->total_price)</b>
                                          <br><br>
                                            <?php
                                            
                                                $beli= Crypt::encrypt($value->first()->transactions_id);
                                            ?>
                                          <a href="#" data-target="#modalupdate{{$value->first()->transaction->code}}" data-toggle="modal" class="belilagi">Pesanan Diterima</a>
                                          <a href="{{ route('rincian-pesanan', ['code'=>$value->first()->transaction->code,'id'=>$parameter]) }}" class="variasi">Rincian Pesanan</a></td>
                                          <?php $totalPrice = 0 ?>
                                    </tr>
                                    <div class="modal fade" id="modalupdate{{$value->first()->transaction->code}}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                              <div class="modal-body">
                                                  <form action="{{ route('konfirmasipesanan', ['code'=>$value->first()->id,'id'=>$parameter] ) }}" method="post" enctype="multipart/form-data">
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
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
  <script src="https://unpkg.com/vue-toasted"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script>
    var locations = new Vue({
      el: "#locations",
      mounted(){
        AOS.init();
        this.getProvincesData();
        this.getRegenciesData();
      },
      data:{
        provinces:null,
        regencies:null,
        districts:null,
        provinces_id:null,
        regencies_id:null,
        districts_id:null,
      },
      methods:{
        getProvincesData(){
          var self = this;
          axios.get('{{ route('api-provinces') }}')
          .then(function(response){
            self.provinces = response.data;
          })
        },
        getRegenciesData(){
          var self = this;
          axios.get('{{ url('api/regencies') }}/' + self.provinces_id)
          .then(function(response){
            self.regencies = response.data;
          })
        },
        getDistrictsData(){
          var self = this;
          axios.get('{{ url('api/districts') }}/' + self.regencies_id)
          .then(function(response){
            self.districts = response.data;
          })
        },
      },
      watch:{
        provinces_id: function(val, oldVal){
          this.regencies_id = null;
          this.getRegenciesData();
        },
        regencies_id: function(val, oldVal){
          this.districts_id = null;
          this.getDistrictsData();
        }
      }
    });
  </script>
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