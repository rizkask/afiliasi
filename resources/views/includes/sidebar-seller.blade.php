<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('/') }}">
    <div class="sidebar-brand-text mx-3">
      MARKETPLACE
    </div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <?php
      $parameter= Crypt::encrypt(Auth::user()->id);
  ?>
  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ (request()->routeIs('seller')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('seller',$parameter) }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('product-seller')) || (request()->routeIs('product-seller-create')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('product-seller',$parameter) }}">
      <i class="fas fa-fw fa-bell"></i>
      <span>Produk</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('transaction-seller')) || (request()->routeIs('transaction-detail-seller')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('transaction-seller',$parameter) }}">
      <i class="fas fa-fw fa-dollar-sign"></i>
      <span>Transaksi</span></a>
  </li>

  <li class="nav-item ">
    <a class="nav-link" href="">
      <i class="fas fa-fw fa-user"></i>
      <span>Pengaturan</span></a>
  </li>

  <hr class="sidebar-divider">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->
