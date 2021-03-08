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
                  <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);" href="{{ route('owner', $parameter) }}">Pemilik Toko</a>
                  <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('bukti', $parameter) }}">Transaksi Masuk</a>
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
                                  <div class="profile-header-img">
                                      @if($item->first()->product->user->image)
                                      <img class="img-circle" src="{{ url(Storage::url($item->first()->product->user->image)) }}" />
                                      @else
                                      <img class="img-circle" src="{{ url('assets/img/store-default.png') }}" />
                                      @endif
                                  </div>
                                  <div class="col-sm info-profil">
                                      <h5><b>{{ $item->first()->product->user->store_name }}</b></h5>
                                      <p>{{ $item->first()->product->user->regency->name }}</p>
                                  </div>
                                  <div class="vl"></div>
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
                                      <h6 class="text-right mr-3"><a href="#" data-target="#modalupdate{{$z->first()->id}}" data-toggle="modal" class="btn "><i class="fas fa-fw fa-store"></i>   Ajukan Komisi</a></h6><a href="{{ route('detail-owner',$item->first()->product->users_id) }}">Lihat Detail</a>
                                      @else
                                        <a href="#" class="btn mr-3">
                                            belum ada komisi
                                        </a>
                                        <a href="{{ route('detail-owner',$item->first()->product->users_id) }}">Lihat Detail</a>
                                      @endif
                                      
                                  </div>
                              </div> 
                              
                          </div> 
                          
                      </div>
                  </div>
              </div>
          </div>
      </div>
    @endforeach
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Toko</th>
                        <th>Komisi Diterima</th>
                        <th>Komisi Diajukan</th>
                        <th>Komisi Baru</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $i=1 ?>
                              
                    @forelse($x as $item)
                      <tr>
                          <?php $total=0; 
                          $claimed=0;
                           ?>
                          <td>{{ $item->first()->product->user->store_name }}</td>
                              <?php 
                                  $w=$item->where('claims_id','!=',NULL);
                                  $r = claim::where('afiliator_id', Auth::user()->id)->where('confirm',0)->where('owner_id',$item->first()->users_id)->get();

                                  foreach($r as $s){
                                      $claimed += $s->total_claim;
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