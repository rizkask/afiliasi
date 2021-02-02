@extends('layouts.seller')

@section('title')
    Seller Dashboard
@endsection

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
      </div>

      <?php
          $parameter= Crypt::encrypt(Auth::user()->id);
      ?>

      <div class="card show mb-4">
          <nav>
              <div class="nav nav-tabs nav-fill" id="nav-tab">
                  <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('list-affiliate', $parameter) }}">Produk Rekomendasi Saya</a>
                  <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('affiliate-transaction', $parameter) }}">Transaksi</a>
                  <a class="nav-item nav-link" style="color: rgb(141, 141, 141);"  href="{{ route('owner', $parameter) }}">Pemilik Toko</a>
                  <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);" href="{{ route('bukti', $parameter) }}">Transaksi Masuk</a>
              </div>
          </nav>
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Toko</th>
                        <th>Total Komisi</th>
                        <th>Bukti Transfer</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $i=1 ?>
                              
                    @forelse($transaction as $item)
                      <tr>
                          <?php 
                              $cek = bukti::where('id', $item->bukti)->get(); 
                              $toko = claim::where('id', $cek->first()->claim_id)->get();
                              $owner = user::where('id', $toko->first()->owner_id)->get();
                          ?>
                          <td>{{ $owner->first()->store_name }}</td>
                          <td>{{ $toko->first()->total_claim }}</td>
                          <td>
                              <a href="{{ Storage::url($cek->first()->image) }}" class="href" >
                                    Lihat Bukti
                              </a>
                          </td>
                          <td>
                            @if($cek->first()->confirm == 1)
                                <span class="badge badge-secondary">Confirmed</span>
                            @else
                                <a href="{{ route('confirm',$cek->first()->id) }}" > 
                                    <span class="badge badge-success">Confirm</span>
                                </a>
                            @endif
                          </td>
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

</div>

@endsection