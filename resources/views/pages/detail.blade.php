@extends('layouts.app')
@section('title', 'Detail Produk')

@section('content')
<main id="main">

    <section id="about-us" class="about-us">
        <div class="container">
            <div class="row no-gutters">
                <div class="image col-xl-5">
                    <img src="{{ url($product->galleries->count() ? Storage::url($product->galleries->first()->image) : '') }}" alt="...">
                </div>
                <div class="col-xl-7 pl-0 pl-lg-5 pr-lg-1 align-items-stretch">
                    <div class="content flex-column justify-content-center">
                        <div class="row">
                            <div class="col-md-12 icon-box">
                                <div class="card card-details card-right">
                                    <h2>{{ $product->name }}</h2>
                                    <p>Terjual {{ $product->sold }}</p>
                                    <hr>
                                    @auth
                                    <?php
                                        $parameter= Crypt::encrypt($product->id);
                                    ?>
                                    <form action="{{ route('add_to_cart', $parameter) }}" method="post">
                                        @csrf
                                        <table class="trip-informations">
                                            <input type='hidden' name="pemilik_id" value="{{ $product->users_id }}"/>
                                            <tr>
                                                <th>Harga</th>
                                                <td>
                                                    {{ $product->price }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Pengiriman dari</th>
                                                <td>
                                                    tddcgcnfhjgv
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah</th>
                                                <td>
                                                    <input type='button' value="-" class='qtyminus' field='quantity' onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 0 ) result.value--;return false;"/>
                                                    <input type='text' id="qty" name='quantity' value='1' class='qty' />
                                                    <input type='button' value="+" class='qtyplus' field='quantity'onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;"/>
                                                </td>
                                            </tr>
                                            <!--<tr>
                                                <th width="30%">Variasi</th>
                                                <td width="70%">
                                                    <div class="row variant">
                                                        <input type="radio" id="1" name="button-checkbox" class="variasi"><label for="1">Success Button</label></input>
                                                        <input type="radio" id="2" name="button-checkbox" class="variasi"><label for="2">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                    </div>
                                                </td>
                                            </tr>-->
                                        </table>
                                        <div class="bates">
                                        @if($product->user->id != Auth::user()->id)
                                            <button type="submit" class="btn btn-sm">
                                            Masukkan Keranjang
                                            </button>
                                        @else
                                        @endif
                                        </div>
                                    </form>
                                    @else
                                        <table class="trip-informations">
                                            <tr>
                                                <th>Harga</th>
                                                <td>
                                                    {{ $product->price }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Pengiriman dari</th>
                                                <td>
                                                    tddcgcnfhjgv
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Jumlah</th>
                                                <td>
                                                    <input type='button' value="-" class='qtyminus' field='quantity' onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;"/>
                                                    <input type='text' id="qty" name='quantity' value='1' class='qty' />
                                                    <input type='button' value="+" class='qtyplus' field='quantity'onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;"/>
                                                </td>
                                            </tr>
                                            <!--<tr>
                                                <th>Variasi</th>
                                                <td>
                                                    <div class="row variant">
                                                        <input type="radio" id="1" name="button-checkbox" class="variasi"><label for="1">Success Button</label></input>
                                                        <input type="radio" id="2" name="button-checkbox" class="variasi"><label for="2">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                        <input type="radio" id="3" name="button-checkbox" class="variasi"><label for="3">Success Button</label></input>
                                                    </div>
                                                </td>
                                            </tr>-->
                                        </table>
                                        <div class="bates">
                                            <a href="{{ route('login') }}">
                                                <button type="submit" class="btn btn-sm">
                                                Masukkan Keranjang
                                                </button>
                                            </a>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div><!-- End .content-->
                </div>
            </div>
        </div>
    </section>

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
                        <div class="row">
                            <div class="col-sm">
                                <h4>{{ $product->user->store_name }}</h4>
                                <p>{{ $product->user->regency->name }}</p>
                                <a href="{{ route('profil-toko', $product->user->slug) }}"><h6>Kunjungi Toko</h6></a>
                            </div>
                            <div class="vl"></div>
                            <div class="col-sm info-profil">
                            <?php
                                $sum=product::where('users_id',$product->user->id)->count();
                            ?>
                                <h6>Produk: {{ $sum }}</h6>
                                <h6>Produk Terjual: {{ $sold }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card head-toko fade show" >
                    <div class="card-body">
                        <div>
                            <h5>Deskripsi</h5>
                            <p>{!! $product->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection