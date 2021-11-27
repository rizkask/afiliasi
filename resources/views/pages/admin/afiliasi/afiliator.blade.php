@extends('layouts.admin')

@section('title')
    Afiliasi
@endsection

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Afiliator</h1>
      </div>

      <?php
          $parameter= Crypt::encrypt(Auth::user()->id);
      ?>

      <div class="card show mb-4">
          <nav>
              <div class="nav nav-tabs nav-fill" id="nav-tab">
                <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);"  href="{{ route('afiliasi.create', $parameter) }}">Afiliator</a>
                <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('afiliasi.edit', $parameter) }}">Pengajuan Komisi</a>
              </div>
          </nav>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                          <th>No.</th>
                          <th>Afiliator</th>
                          <th>Produk Afiliasi</th>
                          <th>Total Transaksi</th>
                          <th>Total Komisi</th>

                      </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                                
                      @forelse($transaction as $item)
                        <tr>
                            <td class="text-center">{{ $i }}.</td><?php $i++ ?>
                              <?php $cek = user::where('id',$item->first()->ref)->first(); $total=0;?>
                            <td>{!! $cek->name !!}</td>
                              <?php
                                  $products = affiliate::where('users_id',$cek->id)->get();
                                  $jmltransaksi = TransactionDetail::where('ref',$cek->id)->whereHas('transaction', function($transaction){
                                                        $transaction->where('transaction_status','SUCCESS');
                                                    })->count();
                              ?>
                            <td>@foreach($products as $product)
                                  
                                - {{ $product->product->name }}<br> 
                                @endforeach
                            </td>
                            <td>@foreach($products as $product)
                                <?php $perproduk = TransactionDetail::where('ref',$cek->id)->where('products_id', $product->product->id)->whereHas('transaction', function($transaction){
                                                        $transaction->where('transaction_status','SUCCESS');
                                                    })->count(); ?>
                                {{ $perproduk }} transaksi<br>
                                @endforeach
                            </td>
                              
                              <?php 
                              foreach($item as $p){
                              $total += $p->product->komisi; 
                              }
                              ?>
                            
                            <td>@currency($total)</td>
                            
                        </tr>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Data Kosong
                            </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                  
              </div>
          </div>
      </div>

@endsection