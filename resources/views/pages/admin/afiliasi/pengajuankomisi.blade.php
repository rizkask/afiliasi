@extends('layouts.admin')

@section('title')
    Pengajuan Komisi Afiliasi
@endsection

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengajuan Komisi</h1>
      </div>

      <?php
          $parameter= Crypt::encrypt(Auth::user()->id);
      ?>

      <div class="card show mb-4">
          <nav>
              <div class="nav nav-tabs nav-fill" id="nav-tab">
                  <a class="nav-item nav-link" style="color: rgb(141, 141, 141);" href="{{ route('afiliasi.create', $parameter) }}">Afiliator</a>
                  <a class="nav-item nav-link active" style="color: rgb(141, 141, 141);" href="{{ route('afiliasi.edit', $parameter) }}">Pengajuan Komisi</a>
              </div>
          </nav>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                          <th>No.</th>
                          <th>Afiliator</th>
                          <th>Komisi</th>
                          <th>Waktu Pengajuan</th>
                          <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                                
                      @forelse($claim as $item)
                        <tr>
                            <td class="text-center">{{ $i }}.</td><?php $i++ ?>
                            <?php $cek = user::where('id',$item->afiliator_id)->get(); ?>
                            <td>{{ $cek->first()->name }}</td>
                            <td>@currency($item->total_claim)</td>
                            <td>{{ $item->created_at->addMinutes(421) }}</td>
                            <td class="text-center">
                              <?php $tes = bukti::where('claim_id',$item->id)->get();?>
                              @if($tes->count() > 0)
                                <a href="{{ Storage::url($tes->first()->image) }}" class="btn" >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <a href="#" data-target="#modalupdate{{$item->id}}" data-toggle="modal" class="btn"> 
                                  <i class="fa fa-pencil-alt"></i>
                                </a>
                                
                              @else
                                <a href="#" data-target="#modalupdate{{$item->id}}" data-toggle="modal" class="btn btn-sm btn-success shadow-sm" style="font-size: 13px;">
                                    + Bukti Transfer
                                </a>
                              @endif
                            </td>
                        </tr>

                          <div class="modal fade" id="modalupdate{{$item->id}}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Upload Foto Bukti Transfer</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">

                                  <form action="{{ route('upload-bukti',$item->id) }}" method="post" enctype="multipart/form-data">
                                      @csrf

                                      <div class="form-group">
                                        <label for="image">Bukti Transfer</label>
                                        <input type="file" class="form-control" name="image" placeholder="Gambar" required>
                                      </div>

                                      <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                  </form>

                                </div>
                              </div>
                            </div>
                          </div>

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