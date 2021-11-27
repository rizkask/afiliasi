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
                  <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);" href="{{ route('owner', $parameter) }}">Pemilik Toko</a>
                  <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('bukti', $parameter) }}">Pemasukan Komisi</a>
              </div>
          </nav><br>
          @foreach($x as $item)
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card head-toko fade show">
                            <div class="card-body">
                                <div class="profile-header-container pull-left">  
                                    <div class="row">
                                        <div class="col-sm info-profil ajukan">
                                            <?php $total=0; 
                                              $claimed=0;
                                            ?>
                                            <?php 
                                                $y=$item->where('claims_id',NULL);
                                                foreach($y as $p){
                                                  $total += $p->product->komisi; 
                                                }
                                            ?>
                                            <h6><span>Komisi: <b style="color:rgb(67, 163, 62);">@currency($total)</b></span></h6>
                                        </div>
                                        <div class="col-sm info-profil ajukan">
                                            <?php 
                                                $z=$item->where('claims_id',NULL);
                                            ?>
                                            @if($z->count() > 0)
                                            <a href="#" data-target="#modalupdate{{$item->first()->product->user->id}}" data-toggle="modal" class="btn claim mr-3"> Ajukan Komisi</a>
                                            <a href="#" data-target="#detail{{$item->first()->product->user->id}}" data-toggle="modal" class="btn detail">Lihat Detail</a>
                                            @else
                                              <a href="#" class="btn novalid mr-3">
                                                  Ajukan Komisi
                                              </a>
                                              <a href="{{ route('detail-owner', $item->first()->product->users_id) }}" class="btn detail">Lihat Detail</a>
                                            @endif
                                            
                                        </div>
                                          <?php 
                                              $w=$item->where('claims_id','!=',NULL);
                                              $r = claim::where('afiliator_id', Auth::user()->id)->where('confirm',0)->where('owner_id',$item->first()->product->users_id)->get();

                                              foreach($r as $s){
                                                  $claimed += $s->total_claim;
                                              }

                                              $confirm = 0;
                                              $c = claim::where('afiliator_id', Auth::user()->id)->where('confirm',1)->where('owner_id',$item->first()->product->users_id)->get();
                                              
                                              foreach($c as $p){
                                                $confirm += $p->total_claim; 
                                              }
                                          ?>
                                        <div class="modal fade" id="modalupdate{{$item->first()->product->user->id}}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Ajukan Claim Komisi</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">

                                                  <form action="{{ route('claim',$item->first()->id) }}" method="post" enctype="multipart/form-data">
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
                                        <div class="modal fade" id="detail{{$item->first()->product->user->id}}" tabindex="-1" aria-labelledby="detail" aria-hidden="true">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title">Detail Pengajuan</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group">
                                                      <label for="claim">Komisi yang sedang diajukan</label>
                                                      <input type="text" name="claim" value="@currency($claimed)" required class="form-control" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="claim">Komisi yang telah di terima</label>
                                                      <input type="text" name="claim" value="@currency($confirm)" required class="form-control" disabled>
                                                    </div>

                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div> 
                                    
                                </div> 
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          @endforeach
      </div>

</div>

@endsection