@extends('layouts.admin')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="tombol d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User</h1>
    </div>

    <div class="card show mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1 ?>
                                
                        @forelse($items as $item)
                            <tr>
                                <td class="text-center">{{ $i }}.</td><?php $i++ ?>
                                <td>{!! $item->name !!}</td>
                                @if($item->email_verified_at != NULL)
                                <td>{!! $item->email !!} <i class="fas fa-fw fa-check-circle" style="color:#1eb4eb;"></i></td>
                                @else
                                <td>{!! $item->email !!}</td>
                                @endif
                                @if($item->address_one)
                                <td>{!! $item->address_one !!}, {{ $item->regencies_name }}<br>
                                    {{ $item->provinces_id }}, {{ $item->zip_code }}
                                </td>
                                @else
                                <td>-</td>
                                @endif
                                @if($item->phone_number)
                                <td>{!! $item->phone_number !!}</td>
                                @else
                                <td>-</td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('user.edit', $item->id) }}" class="btn btn-outline-info btn-round"> 
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <a href="#" data-target="#myModal{{$item->id}}" data-toggle="modal" data-url="{{ route('user.destroy', $item->id) }}" class="hapus btn btn-outline-danger btn-round">
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
                                        <form action="{{ route('user.destroy', $item->id) }}" id="deleteForm" method="post" class="d-inline">
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