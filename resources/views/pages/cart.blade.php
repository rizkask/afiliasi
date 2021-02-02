@extends('layouts.app')

@section('title')
    cart
@endsection

@section('content')
<br><br>
<div class="container">
	<div class="row">

        <div class="col-md-9">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover shopping-cart-wrap" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-muted">
                                <tr>
                                    <!--<th scope="col">
                                        <label>
                                            <input type="checkbox" name="select-all" id="select-all" />
                                        </label>
                                    </th>-->
                                    <th scope="col">Produk</th>
                                    <th scope="col">Harga Satuan</th>
                                    <th scope="col">Kuantitas</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
        </div>

        
        @foreach($carts as $p => $value)
            <div class="col-md-9">
                <div class="card show mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover shopping-cart-wrap" id="dataTable" width="100%" cellspacing="0">
                                <thead class="text-muted">
                                    <tr class="text-left">
                                        <!--<th scope="col">
                                            <label>
                                                <input type="checkbox" name="select-all" id="select-all" />
                                            </label>
                                        </th>-->
                                        <th colspan="5"><i class="fas fa-store"></i> <a href="{{ route('profil-toko', $value->first()->product->user->slug) }}" class="href">{{ $value->first()->product->user->store_name }}</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($value as $cart)
                                            <tr>
                                                <!--<td>
                                                    <input class="my-activity" type="checkbox" name="activity{{ $cart->id }}" value="{{ $cart->product->price }}" />
                                                </td>-->
                                                <td>
                                                    <div class="produk-cart pull-left mr-3">
                                                        <a href="{{ route('detail', $cart->product->slug) }}">
                                                            <img src="{{ url($cart->product->galleries->count() ? Storage::url($cart->product->galleries->first()->image) : '') }}" alt="...">
                                                        </a>
                                                    </div>
                                                    <div class="row">
                                                        <a href="{{ route('detail', $cart->product->slug) }}">{{ $cart->product->name }}</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    @currency($cart->product->price)
                                                </td>
                                                <td>
                                                        <input type='text' name='quantity{{$cart->id}}' value='{{ $cart->quantity }}' class='qty' disabled/>
                                                </td>
                                                <td>
                                                    @currency($cart->product->price*$cart->quantity)
                                                </td>
                                                <td>
                                                    <a href="{{ route('cart-delete', $cart->id) }}" class="hapus btn btn-round">
                                                        <i style="color: #747474;" class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $totalPrice += $cart->product->price*$cart->quantity ?>
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
                    <form action="{{ route('checkout',$value->first()->id) }}" method="post">
                    @csrf
                        <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                        <?php $totalPrice = 0 ?>
                        <button type="submit" class="btn btn-block btn-join-now py-2">
                            Beli
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
        
	</div>
</div>
<br><br><br>
@endsection
@push('add-on')
<script>
    $(document).ready(function() {        
        $(".qtyplus").click(function(event) {
            var total = 0;

            total += parseInt($(this).val());
            
            if (total == 0) {
                $('#amount').val('');
            } else {                
                $('#amount').val(total);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {        
        $(".qtyminus").click(function(event) {
            var total = 0;

            total -= parseInt($(this).val());
            
            if (total == 0) {
                $('#amount').val('');
            } else {                
                $('#amount').val(total);
            }
        });
    });    
</script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-CjfNfNE4gZUkNvPP"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{$token}}', {
            // Optional
            onSuccess: function(result){
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onPending: function(result){
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result){
                document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
    };
</script>
@endpush