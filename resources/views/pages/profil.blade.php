@extends('layouts.app')

@section('title')
    Profil
@endsection

@section('content')
<br>
<!------ Include the above in your HEAD tag ---------->
<div class="container">
          
	<div class="row">
		<div class="col-md-2 ">
		      <div class="list-group ">
              <?php
                  $parameter= Crypt::encrypt(Auth::user()->id);
              ?>
              <a href="{{ route('profil', $parameter) }}" style="font-size: 14px; color:rgb(67, 163, 62);" class="list-group-item list-group-item-action">Akun Saya</a>
              <a href="{{ route('pass', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Ubah Password</a>
              <a href="{{ route('pesanan-saya', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Pesanan Saya</a>
              <a href="{{ route('afiliasi', $parameter) }}" style="font-size: 14px;" class="list-group-item list-group-item-action">Afiliasi</a>
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
                                <label for="name" class="col-4 col-form-label">Nama Lengkap</label> 
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
                                <label for="address_one" class="col-4 col-form-label">Alamat</label> 
                                <div class="col-8">
                                  <p>
                                  @if(Auth::user()->regencies_id && Auth::user()->provinces_id)
                                  
                                    {{ $item->address_one }}<br>
                                    {{ $item->regencies_name }}, {{ $item->zip_code}}<br>
                                    {{ $item->provinces_id }}
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
        <form  action="{{ route('update-address',$parameter) }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label>Provinsi</label>
            <select class="form-control" name="nama_provinsi">
              
            </select>
          </div>

          <div class="form-group">
            <label>Kota/Kabupaten</label>
            <select class="form-control" name="nama_distrik">

            </select>
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

  <script>

      $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      });
      
      $(document).ready(function(){
          $.ajax({
              type:'post',
              url:"{{ URL::to('profil/dataprovinsi') }}",
              success:function(hasil_provinsi)
              {
                  $("select[name=nama_provinsi]").html(hasil_provinsi);
              }
          });

          $("select[name=nama_provinsi]").on("change",function(){
              var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");
              $.ajax({
                  type:'post',
                  url: "{{ URL::to('profil/datadistrik') }}",
                  data: 'id_provinsi='+id_provinsi_terpilih,
                  success:function(hasil_distrik)
                  {
                    $("select[name=nama_distrik]").html(hasil_distrik);
                  }
              })
          });

          $("select[name=nama_distrik]").on("change",function(){
              var nama_distrik_terpilih = $("option:selected", this).attr("nama_distrik");
              var tipe_distrik = $("option:selected", this).attr("tipe_distrik");
              $('<input>').attr({
                    type: 'hidden',
                    name: 'regencies_name',
                    value: tipe_distrik+" "+nama_distrik_terpilih,
              }).appendTo('form')
          });
      });
  </script>
@endpush