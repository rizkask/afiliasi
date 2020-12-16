@extends('layouts.buat-login')

@section('content')
<div class="bg-image"></div>
<div class="container-login">
	<div class="d-flex justify-content-center h-100">
		<div class="card-login">
			<div class="card-body">
				<div class="text-center">
                    <h4 class="h4 text-gray-900 mb-4">Masuk</h4>
                </div>
				<form method="POST" action="{{ route('login') }}">
                    @csrf
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input  type="email" class="form-control @error('email') is-invalid @enderror" name="email" oninvalid="this.setCustomValidity('harap sertakan &quot@&quot di alamat email')" placeholder="email" value="{{ old('email') }}" autofocus>
						@error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="kata sandi" autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
                    
					<div class="row align-items-center remember">
                    <input  type="checkbox" name="remember" id="remember" value="{{ old('remember') ? 'checked' : '' }}">

                        <label  for="remember">
                            {{ __('Ingat Saya') }}      
                        </label>
					</div>
					<div class="form-group text-center">
                        <button type="submit" class="btn login_btn">
                            {{ __('Masuk') }}
                        </button>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Belum punya akun?
                    <a class="btn-link" href="{{ route('register') }}">
                        {{ __('Daftar Sekarang') }}
                    </a>
				</div>
				<div class="d-flex justify-content-center">
                    @if (Route::has('password.request'))
                        <a class="btn-link end" href="{{ route('password.request') }}">
                            {{ __('Lupa kata sandi?') }}
                        </a>
                    @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
