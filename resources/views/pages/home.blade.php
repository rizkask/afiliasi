@extends('layouts.app')

@section('title')
    Toko Online
@endsection

@section('content')
<br>
    <section id="hero">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
            @if($count>0)
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="{{ url($slider->count() ? Storage::url($slider[0]->image) : '') }}" alt="">
                </div>

                <!-- Slide 2 -->
                @if($count>1)
                    @for($i; $i < $count; $i++)
                    <div class="carousel-item">
                        <img src="{{ url($slider->count() ? Storage::url($slider[$i]->image) : '') }}" alt="">
                    </div>
                    
                    @endfor
                @endif
            @endif
            </div>
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>
        </div>
    </section>
    <!-- End Hero -->

    <main id="main">

        <!--<hr width="82%">
        <section id="services" class="services">
            <div class="container">

            <div class="section-title">
                <h2>Categories</h2>
            </div>

            <div class="row space">
            @foreach($categories as $category)
                <div class="col-lg-2 col-md-6">
                <div class="icon-box">
                    <h4 class="title"><a href="">{{ $category->name }}</a></h4>
                </div>
                </div>
            @endforeach
            </div>

            </div>
        </section>-->

        <hr width="82%">
        <section id="contact" class="contact">  
            <div class="container">
                <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="info-wrap">
                        <div class="row">
                            <div class="col-lg-4 info">
                            <i class="icofont-google-map"></i>
                            <h4>Lokasi:</h4>
                            <p>{{ $contact->address_one }}, {{ $contact->regencies_name }}, {{ $contact->provinces_id }}</p>
                            </div>

                            <div class="col-lg-4 info mt-4 mt-lg-0">
                            <i class="icofont-envelope"></i>
                            <h4>E-mail:</h4>
                            <p>{{ $contact->email }}</p>
                            </div>

                            <div class="col-lg-4 info mt-4 mt-lg-0">
                            <i class="icofont-phone"></i>
                            <h4>Telepon:</h4>
                            <p>{{ $contact->phone_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <hr width="82%">

        <!-- ======= Hotels Section ======= -->
        <section id="hotels" class="section-with-bg wow fadeInUp">

            <div class="container">
                <div class="section-title">
                    <h2>Rekomendasi</h2>
                </div>

                <div class="row recommend">
                @foreach($products as $product)
                    <div class="cek">
                        <div class="hotel">
                            <div class="hotel-img">
                                <a href="{{ route('detail', $product->slug) }}">
                                    <img src="{{ url($product->galleries->count() ? Storage::url($product->galleries->first()->image) : '') }}" alt="...">
                                </a>
                            </div>
                            <a href="{{ route('detail', $product->slug) }}"><h3 class="truncate">{{ $product->name }}</h3></a>
                            <p><a href="{{ route('detail', $product->slug) }}">@currency($product->price)</a></p>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>

        </section>
        <!-- End Hotels Section -->

    </main>
    <!-- End #main -->
@endsection
