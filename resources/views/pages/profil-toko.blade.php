@extends('layouts.app')

@section('title')
    Profil Toko
@endsection

@section('content')
<br>
  <!-- ======= Our Team Section ======= -->
      <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card head-toko fade show">
                    <div class="card-body">
                        <div class="profile-header-container pull-left mr-4">   
                            <div class="profile-header-img">
                                <img class="img-circle" src="{{ url('assets/img/store-default.png') }}" />
                            </div>
                        </div> 
                        <div class="row" data-aos="fade-up">
                            <div class="col-sm">
                                <h3>{{ $item->store_name }}</h3>
                                <h6>{{ $item->regency->name }}</h6>
                            </div>
                            <div class="vl"></div>
                            <div class="col-sm info-profil">
                                <h6>Produk: </h6>
                                <h6>Produk Terjual:</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

<!------ Include the above in your HEAD tag ---------->
<div class="container">
          
	<div class="row">
		<div class="col-md-12">
		    <div class="card fade show" >
		        <div class="card-body">

                <div class="d-sm-flex align-items-center mb-4">
                    <h4>Produk Toko</h4>
                </div>

		            <div class="row" id="toko">
                  @foreach($products as $product)
                    <div>
                        <div class="hotel">
                            <div class="hotel-img">
                                <a href="{{ route('detail', $product->slug) }}">
                                    <img src="{{ url($product->galleries->count() ? Storage::url($product->galleries->first()->image) : '') }}" alt="...">
                                </a>
                            </div>
                            <a href="{{ route('detail', $product->slug) }}"><h3>{{ $product->name }}</h3></a>
                            <a href="{{ route('detail', $product->slug) }}"><p>@currency($product->price)</p></a>
                            <a href="{{ route('detail', $product->slug) }}"><h6>{{ $product->user->regency->name }}</h6></a>
                        </div>
                    </div>
                  @endforeach
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
<br><br><br>
@endsection