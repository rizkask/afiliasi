@extends('layouts.seller')

@section('title')
    Tambah Produk
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
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('product-seller-store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="text-center profil-img">
                                <label for="cat_image" class="custom-file-upload">
                                    <div class="profile-user-img">
                                        <img class="img-circle" id="category-img-tag" src="{{ url('assets/img/add-image2.png') }}" />
                                    </div>
                                    <input name="image[]" id="cat_image" type="file" multiple/>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="categories_id">Kategori Produk</label>
                                <select name="categories_id" required class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="title">Nama Produk</label>
                                <input type="text" class="form-control" name="name" placeholder="Judul" value="" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="text" class="form-control" name="price" placeholder="Harga Produk" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="editor" placeholder="Deskripsi" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Simpan
                        </button>
                    
                </form>
            </div>
        </div>
    </div>
    <!--modal-->
<div class="modal fade" id="modalupdate{{ $parameter }}" tabindex="-1" aria-labelledby="modalupdate" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Produk Rekomendasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ref" action="{{ route('add-affiliate',$parameter) }}" method="post" enctype="multipart/form-data">
          @csrf
        
          <div class="form-group">
            <label for="address_one">Alamat</label>
            <input type="text" 
            value="{{ url('/product/ref/' . Auth::user()->id . '/' . $items->id) }}" 
            readonly class="form-control">
          </div>

          <button type="submit" class="btn btn-primary float-right">Simpan</button>
        </form>
      <!--END FORM UPDATE BARANG-->
      </div>
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