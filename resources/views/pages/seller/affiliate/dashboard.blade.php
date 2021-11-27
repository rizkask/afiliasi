@extends('layouts.seller')

@section('title')
Afiliasi
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
                  <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);" href="{{ route('owner', $parameter) }}">Pemilik Toko</a>
                  <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('bukti', $parameter) }}">Transaksi Masuk</a>
              </div>
          </nav>
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Komisi Diterima</th>
                        <th>Komisi Claimed</th>
                        <th>Komisi Baru</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $i=1 ?>
                              
                    @forelse($x as $item)
                      <tr>
                          <?php $total=0; 
                          $claimed=0; ?>
                            <?php 
                              $w=$item->where('claims_id','!=',NULL);
                              foreach($w as $p){
                                $claimed += $p->product->komisi; 
                              }

                              $confirm = 0;
                              $c = claim::where('afiliator_id', Auth::user()->id)->where('confirm',1)->where('owner_id',$item->first()->users_id)->get();
                              
                              foreach($c as $p){
                                $confirm += $p->total_claim; 
                              }
                            ?>
                          <td>@currency($confirm)</td>
                          <td>@currency($claimed)</td>
                            <?php 
                              $y=$item->where('claims_id',NULL);
                              foreach($y as $p){
                                $total += $p->product->komisi; 
                              }
                            ?>
                          <td>@currency($total)</td>
                          <td>
                            <?php 
                              $z=$item->where('claims_id',NULL);
                            ?>
                            @if($z->count() > 0)
                              <a href="#" data-target="#modalupdate{{$z->first()->id}}" data-toggle="modal" class="btn ">
                                  <i class="fa fa-eye"></i>
                              </a>
                              <div class="modal fade" id="modalupdate{{$z->first()->id}}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Ajukan Claim Komisi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">

                                        <form action="{{ route('claim',$z->first()->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                              <label for="claim">Total Komisi yang akan di claim</label>
                                              <input type="text" name="claim" value="@currency($total)" required class="form-control" disabled>
                                            </div>

                                            <button type="submit" class="btn btn-primary float-right">Kirim</button>
                                        </form>

                                      </div>
                                    </div>
                                  </div>
                              </div>
                            @else
                              <a href="#" class="btn ">
                                  nothing to claim
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