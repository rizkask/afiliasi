@extends('layouts.seller')

@section('content')
    <!-- Begin Page Content -->
    <div class="container">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Transaction Detail ({{ $item->code }})</h1>
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
                                    <h6>{{ $item->transaction->user->email }}</h6>
                                    <h6><b>Customer Name</b></h6>
                                    <h6>{{ $item->transaction->user->name }}</h6>
                                    <h6><b>Phone Number</b></h6>
                                    <h6>{{ $item->transaction->user->phone_number }}</h6>
                                </div>
                                <div class="vl"></div>
                                <div class="col-sm">
                                    <h6><b>Address</b></h6>
                                    <h6>{{ $item->transaction->user->address_one }}</h6>
                                    <h6><b>Province</b></h6>
                                    <h6>{{ $item->transaction->user->province->name }}</h6>
                                    <h6><b>Regency</b></h6>
                                    <h6>{{ $item->transaction->user->regency->name }}</h6>
                                </div>
                                <div class="vl"></div>
                                <div class="col-sm">
                                    <h6><b>Kode Pos</b></h6>
                                    <h6>{{ $item->transaction->user->zip_code }}</h6>
                                    <h6><b>Total Amount</b></h6>
                                    <h6>@currency($item->price)</h6>
                                    <h6><b>Payment Status</b></h6>
                                    <h6>{{ $item->transaction->transaction_status }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card fade show">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class=" pull-left mr-4">   
                                <div class="profile-header-img">
                                    <img class="img-product" src="{!! url($item->product->galleries->count() ? Storage::url($item->product->galleries->first()->image) : '') !!}" />
                                </div>
                            </div> 
                            <div class="row col-sm-9">
                                <div class="col-sm">
                                    <h6>Product Name: {{ $item->product->name}}</h6>
                                    <h6>Unit Price: @currency($item->product->price)</h6>
                                    <h6>Quantity: </h6>
                                    <h6>Total Price: </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card head-toko fade show">
                    <div class="card-body">
                        <form action="{{ route('transaction-update-seller',$item->id) }}" id="transactionDetails" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group">
                                <label for="shipping_status">Shipping Status</label>
                                <select name="shipping_status" id="status" v-model="status" required class="form-control">
                                    <option value="PENDING">Pending</option>
                                    <option value="SHIPPING">Shipping</option>
                                    <option value="SUCCESS">Success</option>
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
    </div>
    <!-- /.container-fluid -->
@endsection

@push('addon-script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script>
        var transactionDetails = new Vue({
            el: "#transactionDetails",
            data:{
                status: "{{ $item->shipping_status }}",
                resi: "{{ $item->resi }}",
            },
        });
    </script>
@endpush