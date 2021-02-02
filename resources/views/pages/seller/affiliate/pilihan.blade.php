@extends('layouts.seller')

@section('title')
    Tambah Produk
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Buat Rekomendasi Affiliasi</h1>
        </div>
        <?php
            $parameter= Crypt::encrypt(Auth::user()->id);
        ?>

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

        <div class="card show mb-4">
            <div class="card-body">
                <div class="table-responsive">
                            <?php
                                $parameter= Crypt::encrypt(Auth::user()->id);
                            ?>
                    <div class="row col-md-12 siti">
                    
                    @forelse($items as $item)
                        <?php
                            $attributes=['products_id' => $item->id];
                            $user=['users_id' => Auth::user()->id];
                            $cek = affiliate::where($attributes)->where($user)->first();
                        ?>
                        @if($cek == null)
                            <div class="col-md-6 mb-3">
                                <div class="card fade show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="ml-3">
                                                    <img src="{!! Storage::url($item->galleries->first()->image ?? '') !!}" alt="" class="tita img-thumbnail">
                                            </div> 
                                            <div class="col-sm">
                                                <h6>{{ $item->name}} <text style="color:rgb(180, 180, 180);">by {{ $item->user->store_name }}</text></h6>
                                                <h6>@currency($item->price)</h6>
                                                <h6>Komisi: <b>@currency($item->komisi)</b></h6>
                                                
                                                <h6><a href="{{ route('add-affiliate',$item->id) }}" style="font-size:14px;"> 
                                                    <i class="fas fa-plus fa-sm"></i> Tambah ke Rekomendasi
                                                </a><h6>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              
                                <div class="modal fade" id="ref{{ $item->id }}" tabindex="-1" aria-labelledby="ref" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Produk Rekomendasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('add-affiliate',$parameter) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="form-group">
                                                <label for="address_one">Kode Referal</label>
                                                <input type="text" 
                                                value="{{ url('/product/ref/' . Auth::user()->id . '/' . $item->id) }}" 
                                                readonly class="form-control">
                                            </div>

                                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                                            </form>
                                        <!--END FORM UPDATE BARANG-->
                                        </div>
                                        </div>
                                    </div>
                                </div>
                        @else
                        @endif
                    @empty
                        
                    @endforelse
                    
                    </div>
                </div>
            </div>
        </div>
        <!--modal-->
        
    </div>
    <!-- /.container-fluid -->

    
@endsection

@push('addon-script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#category-img-tag').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#cat_image").change(function(){
            readURL(this);
        });
    </script>
@endpush