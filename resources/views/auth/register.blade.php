@extends('layouts.buat-login')

@section('content')
<div class="bg-image"></div>
<div class="container-login">
	<div class="d-flex justify-content-center h-100">
		<div class="card-login">
			<div class="card-body">
                <div class="text-center">
                    <h4 class="h4 text-gray-900 mb-4">Registrasi</h4>
                </div>
				<form class="user" method="POST" action="{{ route('register') }}">
                    @csrf
					<div class="form-group">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror form-control-user" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    
                    <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-user" name="email" placeholder="Email" oninvalid="this.setCustomValidity('harap sertakan &quot@&quot di alamat email')" title="harap sertakan &quot@&quot di alamat email" value="{{ old('email') }}" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input id="kata_sandi" type="password" class="form-control @error('kata_sandi') is-invalid @enderror form-control-user" name="kata_sandi" placeholder="Kata Sandi" autocomplete="new-password">
                            @error('kata_sandi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <input id="konfirmasi_kata_sandi" type="password" class="form-control @error('kata_sandi') is-invalid @enderror form-control-user" name="konfirmasi_kata_sandi" placeholder="Konfirmasi Kata Sandi" autocomplete="new-password">
                            @error('konfirmasi_kata_sandi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
					<div class="form-group text-center">
                        <div class="col-sm-12">
                            <button type="submit" class="btn login_btn">
                                {{ __('Daftar') }}
                            </button>
                        </div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
