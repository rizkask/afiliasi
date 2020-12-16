@extends('layouts.app')

@section('title')
    Profil
@endsection

@section('content')
<br><br>
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
              <a href="{{ route('profil', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Profil</a>
              <a href="{{ route('pass', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Ubah Password</a>
          </div> 
		</div>
		<div class="col-md-10">
		    <div class="card fade show" >
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-12">
		                    <h4>Profil Saya</h4>
		                    <hr>
		                </div>
		            </div>
		            <div class="row">
                    
		                <div class="col-md-12">
		                    <form action="{{ route('update-profil', $parameter) }}" method="post" enctype="multipart/form-data">
                          @csrf
                          <div class="row">
                            <div class="col-md-9">
                              <div class="form-group row">
                                <label for="name" class="col-4 col-form-label">Nama Lengkap *</label> 
                                <div class="col-8">
                                  <input id="name" name="name" value="{{ $item->name }}" class="form-control @error('name') is-invalid @enderror" type="text">
                                  @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="email" class="col-4 col-form-label">Email</label> 
                                <div class="col-8">
                                  <input style="cursor: no-drop" id="email" name="email" value="{{ $item->email }}" class="form-control here" required="required" type="text" disabled>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="phone_number" class="col-4 col-form-label">No. Telp/HP </label> 
                                <div class="col-8">
                                  <input id="phone_number" name="phone_number" value="{{ $item->phone_number }}" class="form-control @error('phone_number') is-invalid @enderror"  type="text">
                                  @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="store_name" class="col-4 col-form-label">Nama Toko</label> 
                                <div class="col-8">
                                  <input id="store_name" name="store_name" value="{{ $item->store_name }}" class="form-control @error('store_name') is-invalid @enderror" type="text">
                                  @error('store_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="address_one" class="col-4 col-form-label">Alamat</label> 
                                <div class="col-8">
                                  <p>
                                  @if(Auth::user()->regencies_id && Auth::user()->provinces_id)
                                    {{ $item->address_one }}<br>
                                    {{ $item->regency->name }}, {{ $item->zip_code}}<br>
                                    {{ $item->province->name }}
                                  @else
                                  <input type="text" class="form-control" value="Data Kosong" disabled/>
                                  @endif
                                  </p>
                                  <a href="#" data-target="#modalupdate{{ $parameter }}" data-toggle="modal">
                                      Ubah
                                  </a>
                                </div>
                              </div>
                            </div>

                            <div class="vl"></div>

                            <div class="col-md-2 text-center profil-img">
                                <div class="profile-user-img">
                                    @if($item->image)
                                    <img class="img-circle" id="category-img-tag" src="{{ url(Storage::url($item->image)) }}" />
                                    @else
                                    <img class="img-circle" id="category-img-tag" src="{{ url('assets/img/store-default.png') }}" />
                                    @endif
                                </div>
                                <label for="cat_image" class="custom-file-upload">
                                    Pilih Gambar
                                </label>
                                <input name="image" id="cat_image" type="file"/>
                            </div>
                          </div>

                          <div class="form-group row save-profile">
                            <div class="offset-3 col-8">
                              <button name="submit" type="submit" class="btn ">Simpan</button>
                            </div>
                          </div>
                          
                        </form>
                    </div>

                    
		            </div>
		        </div>
		    </div>
		</div>

<div class="modal fade" id="modalupdate{{ $parameter }}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ubah Alamat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <!--FORM UPDATE BARANG-->
        <form id="locations" action="{{ route('update-address',$parameter) }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="provinces_id">Provinsi</label>
            <select id="provinces_id" class="form-control" name="provinces_id" v-if="provinces" v-model="provinces_id">
              <option v-for="province in provinces" :value="province.id">
                @{{ province.name }}
              </option>
            </select>
            <select v-else class="form-control"></select>
          </div>

          <div class="form-group">
            <label for="regencies_id">Kota/Kabupaten</label>
            <select id="regencies_id" class="form-control" name="regencies_id" v-if="regencies" v-model="regencies_id">
              <option v-for="regency in regencies" :value="regency.id">
                @{{ regency.name }}
              </option>
            </select>
            <select v-else class="form-control"></select>
          </div>

          <div class="form-group">
            <label for="districts_id">Kecamatan</label>
            <select id="districts_id" class="form-control" name="districts_id" v-if="districts" v-model="districts_id">
              <option v-for="district in districts" :value="district.id">
                @{{ district.name }}
              </option>
            </select>
            <select v-else class="form-control"></select>
          </div>

          <div class="form-group">
            <label for="zip_code">Kode Pos</label>
            <input id="zip_code" name="zip_code" value="{{ $item->zip_code }}" class="form-control"  type="text">
          </div>

          <div class="form-group">
            <label for="address_one">Alamat</label>
            <input id="address_one" name="address_one" value="{{ $item->address_one }}" class="form-control"  type="text">
          </div>

          <button type="submit" class="btn btn-primary float-right">Simpan</button>
        </form>
      <!--END FORM UPDATE BARANG-->
      </div>
    </div>
  </div>
</div>
<!-- End Modal UPDATE Barang-->
        
	</div>
</div>
<br><br><br>
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