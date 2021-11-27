@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Detail Transaksi {{ $item->first()->transaction->code }}</h1>
        </div>

        <!-- Content Row -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="card head-toko fade show">
                    <div class="card-body">
                        <div class="row">
                            <div class="row col-sm-12 info-profil">
                                <div class="col-sm">
                                    <h6><b>Email</b></h6>
                                    <h6>{{ $item->first()->transaction->user->email }}</h6>
                                    <h6><b>Nama Pembeli</b></h6>
                                    <h6>{{ $item->first()->transaction->user->name }}</h6>
                                    <h6><b>No. Telepon</b></h6>
                                    <h6>{{ $item->first()->transaction->user->phone_number }}</h6>
                                </div>
                                <div class="vl"></div>
                                <div class="col-sm">
                                    <h6><b>Alamat</b></h6>
                                    <h6>{{ $item->first()->transaction->user->address_one }}, {{ $item->first()->transaction->user->regencies_name }}, {{ $item->first()->transaction->user->provinces_id }}, {{ $item->first()->transaction->user->zip_code }}</h6>
                                    <h6><b>Waktu Transaksi</b></h6>
                                    <h6>{{ $item->first()->transaction->updated_at }}</h6>
                                </div>
                                <div class="vl"></div>
                                <div class="col-sm">
                                    <h6><b>Ongkos Kirim</b></h6>
                                    <h6>@currency($item->first()->transaction->shipping_price)</h6>
                                    <h6><b>Total Pembelian</b></h6>
                                    <h6>@currency($item->first()->transaction->total_price)</h6>
                                    <h6><b>Status Transaksi</b></h6>
                                    @if($item->first()->transaction->transaction_status == 'SUCCESS')
                                    <h6><mark class="badge badge-success">Sudah Bayar</mark></h6>
                                    @elseif($item->first()->transaction->transaction_status == 'PENDING')
                                    <h6><mark class="badge badge-secondary">Belum Bayar</mark></h6>
                                    @elseif($item->first()->transaction->transaction_status == 'CANCELLED')
                                    <h6><mark class="badge badge-danger">Dibatalkan</mark></h6>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(count($item)==1)

        <div class="row">

            <div class="col-md-6">
                <div class="card fade show">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class=" pull-left mr-4">   
                                <div class="profile-header-img">
                                    <img class="img-product" src="{!! url($item->first()->product->galleries->count() ? Storage::url($item->first()->product->galleries->first()->image) : '') !!}" />
                                </div>
                            </div> 
                            <div class="row col-sm-9">
                                <div class="col-sm">
                                    <h6>Nama Produk: {{ $item->first()->product->name}}</h6>
                                    <h6>Harga Unit: @currency($item->first()->price/$item->first()->quantity)</h6>
                                    <h6>Jumlah Pembelian: {{ $item->first()->quantity }}</h6>
                                    <h6>Total Harga: @currency($item->first()->price)</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card head-toko fade show">
                    <div class="card-body">
                        <form action="{{ route('transaction.update',$item->first()->id) }}" id="transactionDetails" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                            <div class="form-group">
                                <label for="shipping_status">Status Pengiriman</label>
                                <select name="shipping_status" id="status" v-model="status" required class="form-control">
                                    <option value="PENDING">Pending</option>
                                    <option value="DIKEMAS">Dikemas</option>
                                    <option value="SHIPPING">Dikirim</option>
                                    <option value="SUCCESS">Selesai</option>
                                    <option value="CANCELLED">Dibatalkan</option>
                                </select>
                            </div>
                            

                            <template v-if="status == 'SHIPPING'">
                                <label for="resi">Resi</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" name="resi" v-model="resi" required>
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success">
                                            Update Resi
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <button type="submit" class="btn btn-primary btn-block">
                            Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @else

        <div class="row">

            <div class="col-md-6">
                <div class="card fade show">
                    <div class="card-body">
                        <div class="row">
                            <div class=" pull-left mr-4">   
                                <div class="profile-header-img">
                                    <img class="img-product" src="{!! url($item->first()->product->galleries->count() ? Storage::url($item->first()->product->galleries->first()->image) : '') !!}" />
                                </div>
                            </div> 
                            <div class="row col-sm-9">
                                <div class="col-sm">
                                    <h6>Nama Produk: {{ $item->first()->product->name}}</h6>
                                    <h6>Harga Unit: @currency($item->first()->price/$item->first()->quantity)</h6>
                                    <h6>Jumlah Pembelian: {{ $item->first()->quantity }}</h6>
                                    <h6>Total Harga: @currency($item->first()->price)</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shipping fade show">
                    <div class="card-body">
                        <form action="{{ route('transaction.update',$item->first()->id) }}" id="transactionDetails" method="post" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                            <div class="form-group">
                                <label for="shipping_status">Status Pengiriman</label>
                                <select name="shipping_status" id="status" v-model="status" required class="form-control">
                                    <option value="PENDING">Pending</option>
                                    <option value="SHIPPING">Dikirim</option>
                                    <option value="SUCCESS">Selesai</option>
                                    <option value="FAILED">Dibatalkan</option>
                                </select>
                            </div>
                            
                            <template v-if="status == 'SHIPPING'">
                                <label for="resi">Resi</label>
                                <div class="input-group mb-4">
                                    <input type="text" class="form-control" name="resi" v-model="resi" required>
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success">
                                            Update Resi
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <button type="submit" class="btn btn-primary btn-block">
                            Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

            @for($i; $i < count($item); $i++)
            <div class="row">

                <div class="col-md-6">
                    <div class="card fade show">
                        <div class="card-body">
                            <div class="row">
                                <div class=" pull-left mr-4">   
                                    <div class="profile-header-img">
                                        <img class="img-product" src="{!! url($item[$i]->product->galleries->count() ? Storage::url($item[$i]->product->galleries->first()->image) : '') !!}" />
                                    </div>
                                </div> 
                                <div class="row col-sm-9">
                                    <div class="col-sm">
                                        <h6>Nama Produk: {{ $item[$i]->product->name}}</h6>
                                        <h6>Harga Unit: @currency($item[$i]->product->price/$item[$i]->quantity)</h6>
                                        <h6>Jumlah Pembelian: {{ $item[$i]->quantity }}</h6>
                                        <h6>Total Harga: @currency($item[$i]->price)</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endfor

        @endif
    </div>
    <!-- /.container-fluid -->
@endsection

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script>
        var transactionDetails = new Vue({
            el: "#transactionDetails",
            data:{
                status: "{{ $item->first()->shipping_status }}",
                resi: "{{ $item->first()->resi }}",
            },
        });
    </script>
@endpush