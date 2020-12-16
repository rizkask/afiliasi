@extends('layouts.seller')

@section('content')
<div class="container-fluid">

    <div class="tombol d-sm-flex align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
    </div>

    <section id="tabs">
        <div class="container">
            <div class="card show mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Code Transaction</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $sells[0]->transaction->code }}</td>
                                    <td>
                                        {{ $sells[0]->product->name }}
                                    </td>
                                    <td>{!! $sells[0]->transaction->user->name !!}</td>
                                    <td>@currency($sells[0]->price)</td>
                                    <td>{!! $sells[0]->created_at !!}</td>
                                    <td class="text-center">
                                        <?php
                                            $parameter= Crypt::encrypt(Auth::user()->id);
                                        ?>
                                        <a href="{{ route('transaction-detail-seller',$sells[0]->id) }}" class="btn ">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                
                                <?php
                                    $i=1;
                                ?>
                                
                                @for($i; $i < count($sells) - 1; $i++)
                                    @if($sells[$i]->transactions_id == $sells[$i+1]->transactions_id)
                                        <tr>
                                            <td>{{ $sells[$i+1]->transaction->code }}</td>
                                            <td>
                                                {{ $sells[$i+1]->product->name }}
                                            </td>
                                            <td>{!! $sells[$i+1]->transaction->user->name !!}</td>
                                            <td>@currency($sells[$i+1]->price)</td>
                                            <td>{!! $sells[$i+1]->created_at !!}</td>
                                            <td class="text-center">
                                                <?php
                                                    $parameter= Crypt::encrypt(Auth::user()->id);
                                                ?>
                                                <a href="{{ route('transaction-detail-seller',$sells[$i+1]->id) }}" class="btn ">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>

                                    @else
                                        <tr>
                                            <td colspan="6">
                                        </tr>
                                        <tr>
                                            <td>{{ $sells[$i+1]->transaction->code }}</td>
                                            <td>
                                                {{ $sells[$i+1]->product->name }}
                                            </td>
                                            <td>{!! $sells[$i+1]->transaction->user->name !!}</td>
                                            <td>@currency($sells[$i+1]->price)</td>
                                            <td>{!! $sells[$i+1]->created_at !!}</td>
                                            <td class="text-center">
                                                <?php
                                                    $parameter= Crypt::encrypt(Auth::user()->id);
                                                ?>
                                                <a href="{{ route('transaction-detail-seller',$sells[$i+1]->id) }}" class="btn ">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        
                                    @endif
                                @endfor
                                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
