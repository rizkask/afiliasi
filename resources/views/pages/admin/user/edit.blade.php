@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah User</h1>
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
                <form action="{{ route('user.update', $item->id) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="title">Nama</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama" value="{{ $item->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="title">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $item->email }}" required>
                    </div>

                    <div class="form-group">
                        <label for="title">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <small>Kosongkan jika tidak ingin mengganti password</small>
                    </div>

                    <div class="form-group">
                        <label for="roles">Roles</label>
                        <select name="roles" required class="form-control">
                            <option value="{{ $item->roles }}" selected>{{ $item->roles }}</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
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
