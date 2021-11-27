@extends('layouts.app')

@section('title')
    Cart
@endsection

@section('content')
<br><br>
<div class="container">
    
	<div class="row" id="goodsTable">

        @if($carts->count() > 0)


            <div class="col-md-8">
                <div class="card show mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover shopping-cart-wrap"  width="100%" cellspacing="0">
                                <thead class="text-muted" style="background-color: #fff;">
                                    <tr style="font-size:14px;">
                                        <th style="width:41%;"><text style="margin-left:11px;">Produk</text></th>
                                        <th class="text-center" style="width:20%;">Harga Satuan</th>
                                        <th class="text-center" style="width:8%;">Kuantitas</th>
                                        <th class="text-center" style="width:21%;">Total Harga</th>
                                        <th class="text-center" style="width:5%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0?>
                                    @foreach($carts as $cart)
                                    
                                        <tr>
                                            <td style="width:41%;">
                                                <div class="produk-cart pull-left mr-3">
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
                                                {{ $cart->quantity }}
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
        
            <div class="col-md-4 total-cart">
                <div class="fix">
                    <div class="card card-details card-right">
                        <h6>Alamat Pengiriman</h6>
                        <table class="cart-total">
                            <tr>
                                <td name="address" width="100%"class="text-left">
                                    <b>{{ $user->name }} </b>
                                    ({{ $user->phone_number }})<br>
                                    {{ $user->address_one }}, {{ $user->regencies_name }}, {{ $user->provinces_id }}, {{ $user->zip_code}}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card card-details card-right">
                        <h6>Pilih Pengiriman</h6>
                        <div class="form-group">
                            <select class="form-control " name="nama_ekspedisi" required>
                                
                            </select>
                        </div>
                            
                        <h6>Pilih Jenis Layanan</h6>
                        <div class="form-group">
                            <select class="form-control " name="nama_ongkir" required>
                                
                            </select>
                        </div>
                    </div>

                    
                    <div class="card card-details card-right">
                        <h6>Ringkasan Belanja</h6>
                        <table class="cart-total">
                            <tr>
                                <th width="50%">Total Harga</th>
                                <td width="50%" class="text-right">
                                    @currency($totalPrice)
                                </td>
                            </tr>
                            <tr>
                                <th id="th" width="50%"></th>
                                <td id="td" width="50%" class="text-right">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card card-details card-right">
                        <table class="cart-total">
                            <tr>
                                <th width="50%">Total Tagihan</th>
                                <td width="50%" class="text-right">
                                    <b id="totaltagihan">-</b>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="buy-container">
                        <form action="{{ route('checkout') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="total_price" name="total_price">
                            <input type="hidden" id="shipping_price" name="shipping_price">
                            <?php $totalPrice = 0 ?>
                            <button type="submit" id="submit" class="btn btn-block btn-join-now py-2">
                                Beli
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="container">
                <div class="text-center cart-kosong col-md-12">
                    <h6 style="color: rgb(156, 156, 156); margin-bottom:20px;">Keranjang belanja Anda kosong</h6>
                    <a href="{{ route('/') }}" class="belisekarang">Beli Sekarang</a>
                </div>
            </div>

        @endif
        
	</div>
</div>
<br><br><br>

@endsection

@push('addon-script')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-CjfNfNE4gZUkNvPP"></script>

<script>

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).ready(function () {
        $.ajax({
            type: 'post',
            url: "{{ URL::to('/dataekspedisi') }}",
            success:function(hasil_ekspedisi)
            {
                $("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
            }
        });
    });

    $("select[name=nama_ekspedisi]").on("change",function(){
        var ekspedisi_terpilih = $("select[name=nama_ekspedisi]").val();

        var distrik = function(){
            var distrik;
            $.ajax({
                'async': false,
                'type': 'post',
                'datatype': 'json',
                'data':{ 
                    _token:'{{ csrf_token() }}'
                },
                'cache': false,
                'url': "{{ URL::to('/getAddress') }}",
                success:function(dataResult)
                {
                    distrik = dataResult;
                }
            });
            return distrik;
        }();

        var total_berat = function(){
            var total_berat;
            $.ajax({
                'async': false,
                'type': 'post',
                'datatype': 'json',
                'data':{ 
                    _token:'{{ csrf_token() }}'
                },
                'cache': false,
                'url': "{{ URL::to('/getWeight') }}",
                success:function(dataResult)
                {
                    total_berat = dataResult;
                }
            });
            return total_berat;
        }();

        $.ajax({
            type: 'post',
            url: "{{ URL::to('/dataongkir') }}",
            data: 'ekspedisi='+ekspedisi_terpilih+'&distrik='+distrik+'&berat='+total_berat,
            success:function(hasil_ongkir)
            {
                $("select[name=nama_ongkir]").html(hasil_ongkir);
            }
        });

        $('#th').empty();
        $('#td').empty();
        $('#totaltagihan').empty();
        $('#total_price').removeAttr( "value" );
        $('#shipping_price').removeAttr( "value" );

        var total = document.getElementById('totaltagihan');
        var texttotal = document.createTextNode("-");
        total.appendChild(texttotal);


    });

    

    $("select[name=nama_ongkir]").on("change",function(){
        var total = function(){
            var total;
            $.ajax({
                'async': false,
                'type': 'post',
                'datatype': 'json',
                'data':{ 
                    _token:'{{ csrf_token() }}'
                },
                'cache': false,
                'url': "{{ URL::to('/getTotalPrice') }}",
                success:function(dataResult)
                {
                    total = dataResult;
                }
            });
            return total;
        }();

        var ongkir = $("option:selected", this).attr("ongkir");
        var output;
        output = parseInt(ongkir) + parseInt(total);

        if(document.getElementById("th").value == ""){
            var th = document.getElementById('th');
            var td = document.getElementById('td');
            var textth = document.createTextNode("Total Ongkos Kirim");
            th.appendChild(textth);
            let nf = Intl.NumberFormat('de-DE');
            var texttd = document.createTextNode("Rp "+nf.format(ongkir));
            td.appendChild(texttd);
            
            var total = document.getElementById('totaltagihan');
            var texttotal = document.createTextNode("Rp "+nf.format(output));
            total.appendChild(texttotal);
        }
        else{
            $('#th').empty();
            $('#td').empty();
            var th = document.getElementById('th');
            var td = document.getElementById('td');
            var textth = document.createTextNode("Total Ongkos Kirim");
            th.appendChild(textth);
            let nf = Intl.NumberFormat('de-DE');
            var texttd = document.createTextNode("Rp "+nf.format(ongkir));
            td.appendChild(texttd);

            $('#totaltagihan').empty();
            var total = document.getElementById('totaltagihan');
            var texttotal = document.createTextNode("Rp "+nf.format(output));
            total.appendChild(texttotal);
        }
        ///////////

        if(document.getElementById("total_price").value == ""){
            document.getElementById('total_price').setAttribute("value", output);
        }
        else{
            $('#total_price').removeAttr( "value" );
            document.getElementById('total_price').setAttribute("value", output);
        }
        ///////////

        if(document.getElementById("shipping_price").value == ""){
            document.getElementById('shipping_price').setAttribute("value", ongkir);
        }
        else{
            $('#shipping_price').removeAttr( "value" );
            document.getElementById('shipping_price').setAttribute("value", ongkir);
        }

        
        
    });
    
</script>


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

<script>
    $(document).ready(function() {        
        $(".my-activity").click(function(event) {
            var total = 0;
            $(".my-activity:checked").each(function() {
                total += parseInt($(this).val());
            });
            
            if (total == 0) {
                $('#amount').val('');
            } else {                
                $('#amount').val(total);
            }
        });
    });    
</script>
@endpush