<!DOCTYPE html>
<html>
<head>
	<title>Faktur</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}

		.blok{
			background-color: #f5f5f59c;
		}

		p{
			margin-left: 10px;
			margin-right: 10px;
		}
	</style>
	<center>
		<h4>MARKETPLACE</h4>
	</center>

	<div class="row">
		<div class="col-md-12">
			<p style="font-size:13px;">
				<b>Kode Transaksi:</b><br>
				{{ $items->first()->transaction->code }}
			</p>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="blok">
				<div>
					<p style="font-size:13px;">
						<b>Nama Pembeli:</b><br>
						{{ $items->first()->transaction->user->name }}<br>
						<b>Alamat:</b><br>
						{{ $items->first()->transaction->user->address_one }}, 
						{{ $items->first()->transaction->user->regency->name }}, {{ $items->first()->transaction->user->province->name }}, {{ $items->first()->transaction->user->zip_code}}<br>
						<b>No. Handphone Pembeli:</b><br>
						{{ $items->first()->transaction->user->phone_number}}<br>
						<b>Nama Toko Penjual:</b><br>
						{{ $items->first()->product->user->store_name }}
					</p>
				</div>
			</div>
		</div>
	</div>
	<br><br>

	
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No.</th>
				<th>Produk</th>
				<th>Harga Produk</th>
				<th>Kuantitas</th>
				<th>Subtotal</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
		@foreach($items as $item)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{ $item->product->name }}</td>
				<td>@currency($item->product->price)</td>
				<td>{{ $item->quantity }}</td>
				<td>@currency($item->quantity*$item->product->price) </td>
			</tr>
		@endforeach
		</tbody>
	</table>
	
	<div class="row" style="text-align:right;">
		<div class="col-md-12">
			<p style="font-size:13px;">
				<b>Total Pembayaran: @currency($items->first()->transaction->total_price)</b><br>
			</p>
		</div>
	</div>
 
</body>
</html>