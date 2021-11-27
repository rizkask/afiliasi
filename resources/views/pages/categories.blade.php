@extends('layouts.app')

@section('title')
    Toko Online
@endsection

@section('content')
<section id="hotels"  >
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

    <div class="row recommend">
        @foreach($products as $product)
            <div class="cek filter-{{$product->category->name}}">
                <div class="hotel">
                    <div class="hotel-img">
                        <a href="{{ route('detail', $product->slug) }}">
                            <img src="{{ url($product->galleries->count() ? Storage::url($product->galleries->first()->image) : '') }}" alt="...">
                        </a>
                    </div>
                    <a href="{{ route('detail', $product->slug) }}"><h3 class="truncate animals">{{ $product->name }}</h3></a>
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
  var portfolioIsotope = $('.recommend').isotope({
    itemSelector: '.cek',
    layoutMode: 'fitRows'
  });

  $('#portfolio-flters li').on( 'click', function() {
    $("#portfolio-flters li").removeClass('filter-active');
    $(this).addClass('filter-active');

    portfolioIsotope.isotope({ filter: $(this).data('filter') });
  });

</script>
@endpush