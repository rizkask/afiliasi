@extends('layouts.app')

@section('title')
    Profil
@endsection

@section('content')
<br><br>
<!------ Include the above in your HEAD tag ---------->
<div class="container">
	<div class="row">
          
		<div class="col-md-3 ">
		      <div class="list-group ">
              <?php
                  $parameter= Crypt::encrypt(Auth::user()->id);
              ?>
              <a href="{{ route('profil', $parameter) }}" class="list-group-item list-group-item-action">Profil</a>
              <a href="{{ route('pass', $parameter) }}" class="list-group-item list-group-item-action">Ubah Password</a>
          </div> 
		</div>
		<div class="col-md-9">
        <div class="card fade show"  id="password" >
		        <div class="card-body">
		            <div class="row">
		                <div class="col-md-12">
		                    <h4>Ubah Password</h4>
		                    <hr>
		                </div>
		            </div>
		            <div class="row">
		                <div class="col-md-12">
                          <form action="{{ route('update-pass', $parameter) }}" method="post">
                            @csrf
                              <div class="form-group{{ $errors->has('kata_sandi_lama') ? ' has-error' : '' }} row">
                                <label for="kata_sandi_lama" class="col-4 col-form-label">Kata Sandi Lama *</label> 
                                <div class="col-8">
                                  <input id="kata_sandi_lama" name="kata_sandi_lama" class="form-control @error('kata_sandi_lama') is-invalid @enderror" type="password">
                                  <a href="{{ route('password.request') }}">
                                      Lupa Password?
                                  </a>
                                  @error('kata_sandi_lama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="kata_sandi_baru" class="col-4 col-form-label">Kata Sandi Baru *</label> 
                                <div class="col-8">
                                  <input id="kata_sandi_baru" name="kata_sandi_baru" class="form-control @error('kata_sandi_baru') is-invalid @enderror" type="password">
                                  @error('kata_sandi_baru')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="konfirmasi_kata_sandi_baru" class="col-4 col-form-label">Konfirmasi Kata Sandi Baru *</label> 
                                <div class="col-8">
                                  <input id="konfirmasi_kata_sandi_baru" name="konfirmasi_kata_sandi_baru" class="form-control @error('konfirmasi_kata_sandi_baru') is-invalid @enderror" type="password">
                                  @error('konfirmasi_kata_sandi_baru')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div> 
                              <div class="form-group row">
                                <div class="offset-4 col-8">
                                  <button name="submit" type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
<br><br><br>
@endsection