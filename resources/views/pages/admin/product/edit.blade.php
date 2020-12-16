@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Produk ({{ $item->name }})</h1>
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
                <form action="{{ route('product.update', $item->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title">Nama Produk</label>
                        <input type="text" class="form-control" name="name" placeholder="Judul" value="{{ $item->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="users_id">Pemilik Produk</label>
                        <select name="users_id" required class="form-control">
                            <option value="{{ $item->users_id }}" selected>{{ $item->user->name }}</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="categories_id">Kategori Produk</label>
                        <select name="categories_id" required class="form-control">
                            <option value="{{ $item->categories_id }}" selected>{{ $item->category->name }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="text" class="form-control" name="price" value="{{ $item->price }}" placeholder="Harga Produk" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea name="description" id="editor">{!! $item->description !!}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
