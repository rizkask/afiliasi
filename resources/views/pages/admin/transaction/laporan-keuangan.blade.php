<!DOCTYPE html>
<html>
<head>
	<title>Laporan Keuangan </title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Laporan Keuangan Toko Online</h4>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Tanggal Transaksi</th>
				<th>Paket Travel</th>
				<th>Jumlah Peserta</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($items as $item)
			<tr>
				@if($item->paket_customs_id == NULL)
				<td>{{ $i++ }}</td>
				<td>{{ $item->user->nama_depan }} {{ $item->user->nama_belakang }}</td>
				<td>{{ $item->created_at->addMinutes(421) }}</td>
				<td>{!! $item->travel_package->title !!}</td>
				<td>{{ $item->details->count() }} peserta</td>
				<td>@currency( $item->transaction_total )</td>
				@elseif($item->travel_packages_id == NULL)
				<td>{{ $i++ }}</td>
				<td>{{ $item->user->nama_depan }} {{ $item->user->nama_belakang }}</td>
				<td>{{ $item->created_at->addMinutes(421) }}</td>
				<td>{!! $item->paket_custom->title !!}</td>
				<td>{{ $item->details->count() }} peserta</td>
				<td>@currency( $item->transaction_total )</td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
	<p>Total Pemasukan: @currency($sum)</p>
 
</body>
</html>