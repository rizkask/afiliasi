@extends('layouts.seller')

@section('title')
    Setting
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Buat Produk</h1>
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

        <?php
            $parameter= Crypt::encrypt(Auth::user()->id);
        ?>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('setting-update',$parameter) }}" method="post" enctype="multipart/form-data">
                    @csrf

                        <div class="form-group">
                            <label for="store_name">Store Name</label>
                            <input type="text" class="form-control" name="store_name" value="{{ $item->store_name }}" required>
                        </div>

                        <div class="form-group">
                        <label for="store_name">Store Status</label>
                            <div class="row variant">
                                @if($item->store_status == 1)
                                <input type="radio" id="1" value="1" name="store_status" class="variasi" checked><label for="1">Open Store</label></input>
                                <input type="radio" id="2" value="0" name="store_status" class="variasi"><label for="2">Close Store</label></input>
                                @else
                                <input type="radio" id="1" value="1" name="store_status" class="variasi"><label for="1">Open Store</label></input>
                                <input type="radio" id="2" value="0" name="store_status" class="variasi" checked><label for="2">Close Store</label></input>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn float-right btn-primary">
                            Simpan
                        </button>
                    
                </form>
            </div>
        </div>
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