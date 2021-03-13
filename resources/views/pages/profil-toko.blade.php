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
                                @if($item->image)
                                <img class="img-circle" src="{{ url(Storage::url($item->image)) }}" />
                                @else
                                <img class="img-circle" src="{{ url('assets/img/store-default.png') }}" />
                                @endif
                            </div>
                        </div> 
                        <div class="row toko" >
                            <div class="col-sm">
                                <h3>{{ $item->store_name }}</h3>
                                <h6><i class="fas fa-map-marker-alt"></i> {{ $item->regency->name }}</h6>
                            </div>
                            <div class="vl"></div>
                            <div class="col-sm info-profil">
                                <h6>Produk: {{ $products->count() }}</h6>
                                <h6>Produk Terjual: {{ $sold }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

<!------ Include the above in your HEAD tag ---------->
<main>
    <div class="container">
        <div id="navbar-example">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#about" role="tab">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#atribut" role="tab">Rekomendasi</a>
                </li>
                
            </ul>

            <!-- Tab panes {Fade}  -->
            <div class="tab-content">
                <div class="tab-pane fade in active show" id="about" name="about" role="tabpanel">
                    <div class="card card-details" >
                        <div class="row" id="toko">
                            @foreach($products as $product)
                                    <div class="hotel">
                                        <div class="hotel-img">
                                            <a href="{{ route('detail', $product->slug) }}">
                                                <img src="{{ url($product->galleries->count() ? Storage::url($product->galleries->first()->image) : '') }}" alt="...">
                                            </a>
                                        </div>
                                        <a href="{{ route('detail', $product->slug) }}"><h3 class="truncate">{{ $product->name }}</h3></a>
                                        <a href="{{ route('detail', $product->slug) }}"><p>@currency($product->price)</p></a>
                                        <a href="{{ route('detail', $product->slug) }}"><h6>{{ $product->user->regency->name }}</h6></a>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="atribut" role="tabpanel">
                    <div class="card card-details">
                        <div class="row" id="toko">
                            @foreach($affs as $aff)
                                <div class="hotel">
                                    <div class="hotel-img">
                                        <a href="{{ url('/product/ref/' . $aff->user->id . '/' . $aff->product->id) }}">
                                            <img src="{{ url($aff->product->galleries->count() ? Storage::url($aff->product->galleries->first()->image) : '') }}" alt="...">
                                        </a>
                                    </div>
                                    <a href="{{ url('/product/ref/' . $aff->user->id . '/' . $aff->product->id) }}"><h3 class="truncate">{{ $aff->product->name }}</h3></a>
                                    <a href="{{ url('/product/ref/' . $aff->user->id . '/' . $aff->product->id) }}"><p>@currency($aff->product->price)</p></a>
                                    <a href="{{ url('/product/ref/' . $aff->user->id . '/' . $aff->product->id) }}"><h6>{{ $aff->product->user->regency->name }}</h6></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<br><br><br>
@endsection