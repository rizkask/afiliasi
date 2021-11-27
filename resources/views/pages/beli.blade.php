@extends('layouts.app')

@section('title')
    Checkout
@endsection

@section('content')
<br><br>
<div class="container">
	<div class="row">

            <div class="col-md-9">
                <div class="card show mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table  width="100%" cellspacing="0">
                                <tbody style="font-family:;">
                                    <tr>
                                        <td>
                                            <h6>Alamat Pengiriman</h6><hr>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card show mb-4">
                    <div class="card-body">
                        <table class="table-hover shopping-cart-wrap" style=" border:none;" width="100%" cellspacing="0" cellpadding="0">
                            <thead class="text-muted" style="background-color: #fff;">
                                <tr style="font-size:14px;">
                                    <th class="text-center">Checkout</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        
            

            <div class="col-md-9">
                <div class="card show mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table  width="100%" cellspacing="0">
                                <tbody style="font-family:;">
                                
                                    <tr style="width:100%;">
                                            <h6>Produk Dipesan</h6><hr>
                                    </tr>
                                    <?php $i=0?>
                                    @foreach($carts as $cart)
                                    <tr>
                                        <td style="width:41%;">
                                            <div class="produk-beli pull-left mr-1">
                                                <a href="{{ route('detail', $cart->product->slug) }}">
                                                    <img src="{{ url($cart->product->galleries->count() ? Storage::url($cart->product->galleries->first()->image) : '') }}" alt="...">
                                                </a>
                                            </div>
                                            <div class="row">
                                                <a href="{{ route('detail', $cart->product->slug) }}">{{ $cart->product->name }}</a>
                                            </div>
                                        </td>
                                        <td class="text-center" style="width:20%;">
                                            @currency($cart->product->price)
                                        </td>
                                        <td class="text-center" style="width:8%;">
                                                <input type='text' name='quantity{{$cart->id}}' value='{{ $cart->quantity }}' class='qty' disabled/>
                                        </td>
                                        <td class="text-center" style="width:21%;">
                                            @currency($cart->product->price*$cart->quantity)
                                        </td>
                                        <td class="text-center" style="width:5%;">
                                            <a href="{{ route('cart-delete', $cart->id) }}" class="hapus btn btn-round">
                                                <i style="color: #747474;" class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                        <?php $totalPrice += $cart->product->price*$cart->quantity ?>
                                        <?php $i++;?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-3 total-cart">
                <div class="card card-details card-right">
                    <h6>Ringkasan Belanja</h6>
                    <table class="cart-total">
                        <tr>
                            <th width="50%">Total Harga</th>
                            <td width="50%"class="text-right">
                                @currency($totalPrice)
                            </td>
                            <!--<td width="50%" class="text-right">
                                <input type="text" name="amount" id="amount" />
                            </td>-->
                        </tr>
                    </table>
                </div>
                <div class="buy-container">
                    <form action="{{ route('checkout'), $cart->id }}" method="post">
                        @csrf
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                        <?php $totalPrice = 0 ?>
                        <button type="submit" id="submit" class="btn btn-block btn-join-now py-2">
                            Beli
                        </button>
                    </form>
                </div>
            </div>
        
	</div>
</div>
<br><br><br>


@endsection
@push('add-on')


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-CjfNfNE4gZUkNvPP"></script>
@endpush