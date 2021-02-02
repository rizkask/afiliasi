@extends('layouts.app')

@section('title')
    marketplace
@endsection

@section('content')
<section id="hotels"  class="section-bg" >
    <div class="container">

    

    <div class="row">
        <div class="col-lg-12">
        <ul id="portfolio-flters">
            <li data-filter="*" class="filter-active">All</li>
            @foreach($categories as $category)
            <li data-filter=".filter-{{$category->name}}">{{ $category->name }}</li>
            @endforeach
        </ul>
        </div>
    </div>

    <div class="row recommend portfolio-container">
        @foreach($products as $product)
            <div class="cek portfolio-item filter-{{$product->category->name}}">
                <div class="hotel">
                    <div class="hotel-img">
                        <a href="{{ route('detail', $product->slug) }}">
                            <img src="{{ url($product->galleries->count() ? Storage::url($product->galleries->first()->image) : '') }}" alt="...">
                        </a>
                    </div>
                    <a href="{{ route('detail', $product->slug) }}"><h3>{{ $product->name }}</h3></a>
                    <p><a href="{{ route('detail', $product->slug) }}">@currency($product->price)</a></p>
                </div>
            </div>
        @endforeach
    </div>

    </div>
</section>
@endsection

@push('addon-script')
<script>
  // Porfolio isotope and filter
  var portfolioIsotope = $('.portfolio-container').isotope({
    itemSelector: '.portfolio-item',
    layoutMode: 'fitRows'
  });

  $('#portfolio-flters li').on( 'click', function() {
    $("#portfolio-flters li").removeClass('filter-active');
    $(this).addClass('filter-active');

    portfolioIsotope.isotope({ filter: $(this).data('filter') });
  });

</script>
@endpush