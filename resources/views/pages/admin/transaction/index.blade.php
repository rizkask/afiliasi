@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="tombol d-sm-flex align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>

    <?php
        $parameter= Crypt::encrypt(Auth::user()->id);
    ?>
    <div class="card show mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Waktu Transaksi</th>
                        <th>Kode Transaksi</th>
                        <th>Pembeli</th>
                        <th>Total Pembelian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($sells as $sell)
                            <tr>
                                <td>{{ $sell->created_at->addMinutes(421) }}</td>
                                <td>{{ $sell->code }}</td>
                                <td>{!! $sell->user->name !!}</td>
                                <td>@currency($sell->total_price)</td>

                                @if($sell->details->first()->shipping_status=="PENDING")
                                <td><mark class="badge badge-secondary">Belum Bayar</mark></td>
                                @elseif($sell->details->first()->shipping_status=="DIKEMAS")
                                <td><mark class="badge badge-primary">Dikemas</mark></td>
                                @elseif($sell->details->first()->shipping_status=="SHIPPING")
                                <td><mark class="badge badge-warning">Dikirim</mark></td>
                                @elseif($sell->details->first()->shipping_status=="SUCCESS")
                                <td><mark class="badge badge-success">Selesai</mark></td>
                                @elseif($sell->details->first()->shipping_status=="CANCELLED")
                                <td><mark class="badge badge-danger">Dibatalkan</mark></td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('transaction.edit',$sell->details->first()->id) }}" class="btn ">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Data Kosong
                                </td>
                            </tr>
                        @endforelse
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
</div>
@endsection