@extends('layouts.app')
@section('title', 'Detail Produk')

@section('content')
<main id="main">

    <section id="about-us" class="about-us ">
        <div class="container">
            <div class="row">
                <div class="col-md-4 pl-lg-0">
                    <div class="gallery">
                        <div class="xzoom-container image">
                            <img
                                src="{{ Storage::url($product->galleries->first()->image) }}"
                                class="xzoom"
                                id="xzoom-default"
                                xoriginal="{{ Storage::url($product->galleries->first()->image) }}"
                            />
                        </div>
                        <div class="xzoom-thumbs">
                            @foreach($product->galleries as $gallery)
                                <a href="{{ Storage::url($gallery->image) }}">
                                    <img
                                        src="{{ Storage::url($gallery->image) }}"
                                        class="xzoom-gallery"
                                        width="80" height="80" style="object-fit: cover;"
                                        xpreview="{{ Storage::url($gallery->image) }}"
                                    />
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4 pl-0 pl-lg-5 pr-lg-1 align-items-stretch">
                    <div class="content flex-column justify-content-center">
                        <div class="row">
                            <div class="col-md-12">
                                    <h2>{{ $product->name }}</h2>
                                    <p>Terjual {{ $product->sold }}</p>
                                    <hr>

                                    <p><b>Deskripsi</b><br>
                                        {!! $product->description !!}</p>
                                    <?php
                                        $parameter= Crypt::encrypt($product->id);
                                    ?>
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
                            </div>
                                
                        </div>
                    </div><!-- End .content-->
                </div>
                <div class="col-md-4 pl-0 pl-lg-5 pr-lg-1 align-items-stretch">
                    <div class="content flex-column justify-content-center">
                        <div class="row">
                                <div class="card card-details card-right">
                                    @auth
                                    <?php
                                        $parameter= Crypt::encrypt($product->id);
                                    ?>
                                    <form action="{{ route('add_to_cart', $parameter) }}" method="post">
                                        @csrf
                                        <table class="trip-informations">
                                            <tr>
                                                <th width="40%">Kategori</th>
                                                <td width="60%">
                                                    {{ $product->category->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Harga</th>
                                                <td>
                                                    @currency($product->price)
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="50%">Jumlah</th>
                                                <td width="50%">
                                                    <input type='button' value="-" class='qtyminus' field='quantity' onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;"/>
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
                                            <button type="submit" class="btn btn-sm">
                                            Masukkan Keranjang
                                            </button>
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
                                                <th width="50%">Jumlah</th>
                                                <td width="50%">
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
                    </div><!-- End .content-->
                </div>
                
            </div>
        </div>
    </section>


    <!--<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card head-toko fade show" >
                    <div class="card-body bawah">
                        <div>
                            <h5>Deskripsi Produk</h5>
                            <p>{!! $product->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

</main>
@endsection

@push('prepend-style')
    <link rel="stylesheet" href="{{ url('frontend/libraries/xzoom/dist/xzoom.css') }}" />
@endpush

@push('addon-script')
    <script src="{{ url('frontend/libraries/xzoom/dist/xzoom.min.js') }}"></script>
    <script>
      $(document).ready(function() {
        $('.xzoom, .xzoom-gallery').xzoom({
          title: false,
          tint: '#333',
          Xoffset: 15
        });
      });
    </script>
@endpush