@extends('layouts.app')

@section('title')
    Profil
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
                <div class="tab-pane fade in active show" id="about" name="about" role="tabpanel">
                    <div class="card card-details" >
                        <div class="card-body">
                            <div class="row bs-wizard" style="border-bottom:0;">
                    
                                <div class="col-lg-3 bs-wizard-step complete">
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dibayarkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot "></a>
                                  <div class="bs-wizard-info text-center">{{ $items->created_at }}</div>
                                </div>
                                
                                <div class="col-lg-3 bs-wizard-step complete"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Dikirimkan</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">{{ $items->updated_at }}</div>
                                </div>
                                
                                <div class="col-lg-3 bs-wizard-step active"><!-- complete -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Diterima</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">24392893829392</div>
                                </div>
                                
                                <div class="col-lg-3 bs-wizard-step active"><!-- active -->
                                  <div class="text-center bs-wizard-stepnum">Pesanan Selesai</div>
                                  <div class="progress"><div class="progress-bar"></div></div>
                                  <a href="#" class="bs-wizard-dot"></a>
                                  <div class="bs-wizard-info text-center">8238263816</div>
                                </div>

                            </div>
                            <div class="text-right">
                                <hr>
                                <a href="" class="variasi">Lihat Faktur</a></td>
                            </div>
                        </div>
                    </div>
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