@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
<div class="container-fluid">

      <!-- Page Heading -->
    <div class="tombol d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Transaksi</h1>
        <a href="{{ route('transaction.cetak') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i>Laporan Keuangan
        </a>
    </div>
    <div class="tombol d-sm-flex align-items-center justify-content-between mb-4">
        <p class="h3 mb-0 text-gray-800">Total Biaya Masuk: @currency($sum)</p>
    </div>
      
    <section id="tabs">
        <div class="container">
            <div class="card show mb-4">
                <nav>
                    <div class="nav nav-tabs nav-fill" id="nav-tab">
                        <a class="nav-item nav-link" href="{{ route('transaction.index') }}" aria-selected="true">Paket Travel</a>
                        <a class="nav-item nav-link active" href="{{ route('transaction_custom') }}" aria-selected="false">Paket Custom</a>
                    </div>
                </nav>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="10">ID</th>
                                <th>Paket Custom</th>
                                <th>User</th>
                                <th width="90">Jumlah Penumpang</th>
                                <th width="110">Total</th>
                                <th width="90">Status</th>
                                <th width="118">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1 ?>
                            @forelse($customs as $item)
                                <tr>
                                    <td class="text-center">{{ $i }}</td><?php $i++ ?>
                                    <td>{!! $item->paket_custom->title !!}</td>
                                    <td>{!! $item->user->nama_depan !!}</td>
                                    <td class="text-center">{!! $item->details->count() !!}</td>
                                    <td>@currency($item->transaction_total)</td>
                                    @if($item->transaction_status=="SUCCESS")
                                    <td class="text-center"><mark class="transaction-success">{!! $item->transaction_status !!}</mark></td>
                                    @elseif($item->transaction_status=="PENDING")
                                    <td class="text-center"><mark class="transaction-pending">{!! $item->transaction_status !!}</mark></td>
                                    @elseif($item->transaction_status=="CANCEL")
                                    <td class="text-center"><mark class="transaction-cancel">{!! $item->transaction_status !!}</mark></td>
                                    @elseif($item->transaction_status=="IN_CART")
                                    <td class="text-center"><mark class="transaction-incart">{!! $item->transaction_status !!}</mark></td>
                                    @elseif($item->transaction_status=="FAILED")
                                    <td class="text-center"><mark class="transaction-failed">{!! $item->transaction_status !!}</mark></td>
                                    @endif
                                    <td class="text-center">
                                        <a href="{{ route('transaction-custom.show', $item->id) }}" class="btn btn-outline-primary btn-round">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('transaction.edit', $item->id) }}" class="btn btn-outline-info btn-round">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                        <a href="#" data-target="#myModal{{$item->id}}" data-toggle="modal" data-url="{{ route('transaction.destroy', $item->id) }}" class="hapus btn btn-outline-danger btn-round">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                    </td>
                                </tr>
    <div id="myModal{{$item->id}}" class="modal fade myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <!-- dialog buttons -->
                <form action="{{ route('transaction.destroy', $item->id) }}" id="deleteForm" method="post" class="d-inline">
                    @csrf
                    @method('delete')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
                            @empty
                                <td colspan="7" class="text-center">
                                    Data Kosong
                                </td>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
    <!-- /.container-fluid -->
@endsection
