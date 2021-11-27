<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-text mx-3">
      Toko Online
    </div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ (request()->routeIs('admin-dashboard')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin-dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('slider.index')) || (request()->routeIs('slider.create')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('slider.index') }}">
      <i class="fas fa-fw fa-bell"></i>
      <span>Banner</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('category.index')) || (request()->routeIs('category.create')) || (request()->routeIs('category.edit')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('category.index') }}">
      <i class="fas fa-fw fa-list-alt"></i>
      <span>Kategori</span></a>
  </li>
  
  <li class="nav-item {{ (request()->routeIs('product.index')) || (request()->routeIs('product.create')) || (request()->routeIs('product.edit')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('product.index') }}">
      <i class="fas fa-fw fa-tags"></i>
      <span>Produk</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('user.index')) || (request()->routeIs('user.create')) || (request()->routeIs('user.edit')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user.index') }}">
      <i class="fas fa-fw fa-user"></i>
      <span>Pelanggan</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('transaction.index')) || (request()->routeIs('transaction.edit')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('transaction.index') }}">
      <i class="fas fa-fw fa-dollar-sign"></i>
      <span>Transaksi</span></a>
  </li>
  
  <li class="nav-item {{ (request()->routeIs('afiliasi.create')) || (request()->routeIs('afiliasi.edit')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('afiliasi.create') }}">
      <i class="fas fa-fw fa-link"></i>
      <span>Afiliasi</span></a>
  </li>

  

  <hr class="sidebar-divider">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->
