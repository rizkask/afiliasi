@extends('layouts.app')

@section('title')
    Transaksi Berhasil
@endsection

@section('content')
<br><br>
<div class="container">
    
	<div class="row" id="goodsTable">
        <div class="container">
            <div class="text-center cart-kosong col-md-12">
                <img src="{{ url('assets/img/success.png') }}" alt="">
                <h4 style="color: rgb(156, 156, 156); margin-bottom:20px;">Transaksi Berhasil</h4>
            </div>
        </div>
	</div>
</div>
<br><br><br>

@endsection