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
                <form action="{{ route('product-seller-update',$item->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                        
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
                                <input type="text" class="form-control" name="name" placeholder="Judul" value="{{ $item->name }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="price">Harga</label>
                            <input type="text" class="form-control" name="price" placeholder="Harga Produk" value="{{ $item->price }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" id="editor" placeholder="Deskripsi" required>{!! $item->description !!}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Simpan
                        </button>
                </form>

                <div class="row">
                    @foreach($item->galleries as $gallery)
                    <div class="text-center profil-img">
                        <label for="cat_image" class="custom-file-upload">
                            <div class="profile-user-img">
                                <img class="img-circle" id="category-img-tag" src="{{ url(Storage::url($gallery->image)) }}" />
                            </div>
                        </label>
                    </div>
                    @endforeach
                </div>
                <form action="{{ route('product-seller-gallery-upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="products_id" value="{{ $item->id }}">
                    <input style="display:none;" name="image" id="file" type="file" onchange="form.submit()"/>
                    <button type="button" class="btn btn-primary btn-block" onclick="thisFileUpload()">
                        Add Photo
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    
@endsection

@push('addon-script')
    <script>
        function thisFileUpload() {
            document.getElementById('file').click();
        }
    </script>
@endpush