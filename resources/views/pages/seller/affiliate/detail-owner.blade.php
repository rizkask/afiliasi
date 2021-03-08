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
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pembeli</th>
                        <th>Produk</th>
                        <th>Pemilik</th>
                        <th>Komisi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php $i=1 ?>
                              
                    @forelse($transaction as $item)
                      <tr>
                          <td>{{ $item->code }}</td><?php $i++ ?>
                          <td>{{ $item->transaction->user->name }}</td>
                          <td>{!! $item->product->name !!}</td>
                          <td>{!! $item->product->user->store_name !!}</td>
                          <td>{!! $item->product->komisi !!}</td>
                          <td>{!! $item->ref_status_label !!}</td>
                          <td>{{ $item->created_at }}</td>
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
              <div class="modal fade" id="modalupdate" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Daftar Produk Afiliasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                              <label for="komisi">Komisi</label>
                              <input name="komisi" required class="form-control" type="text">
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>

                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>

</div>

@endsection