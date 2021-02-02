@extends('layouts.seller')

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
                        <th>Date</th>
                        <th>Code Transaction</th>
                        <th>Product</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse($sells as $sell)
                            <tr>
                                <td>{{ $sell->created_at }}</td>
                                <td>{{ $sell->transaction->code }}</td>
                                <td>
                                    {{ $sell->product->name }}
                                </td>
                                <td>{!! $sell->transaction->user->name !!}</td>
                                <td>@currency($sell->price)</td>

                                @if($sell->shipping_status=="PENDING")
                                <td><mark class="badge badge-secondary">{{ $sell->shipping_status }}</mark></td>
                                @elseif($sell->shipping_status=="SHIPPING")
                                <td><mark class="badge badge-success">{{ $sell->shipping_status }}</mark></td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('transaction-detail-seller',$sell->id) }}" class="btn ">
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