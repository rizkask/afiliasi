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
      <i class="fas fa-fw fa-box-open"></i>
      <span>Product</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('transaction-seller')) || (request()->routeIs('transaction-detail-seller')) ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('transaction-seller',$parameter) }}">
      <i class="fas fa-fw fa-dollar-sign"></i>
      <span>Transaction</span></a>
  </li>

  <li class="nav-item {{ (request()->routeIs('affiliate')) || (request()->routeIs('list-affiliate')) || (request()->routeIs('my-product-aff')) || (request()->routeIs('affiliate-transaction')) || (request()->routeIs('afiliator')) 
  || (request()->routeIs('affiliate-transaction')) || (request()->routeIs('owner')) || (request()->routeIs('bukti')) || (request()->routeIs('afiliator')) || (request()->routeIs('afiliator-trans')) || (request()->routeIs('pilih-affiliate')) ? 'active' : '' }}">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-link"></i>
      <span>Affiliate</span></a>
      <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item {{ (request()->routeIs('affiliate')) ? 'active' : '' }}" href="{{ route('affiliate', $parameter) }}">Dashboard</a>
            <a class="collapse-item {{ (request()->routeIs('list-affiliate')) || (request()->routeIs('affiliate-transaction')) || (request()->routeIs('owner')) || (request()->routeIs('bukti')) ? 'active' : '' }}" href="{{ route('list-affiliate', $parameter) }}">Rekomendasi Saya</a>
            <a class="collapse-item {{ (request()->routeIs('my-product-aff')) || (request()->routeIs('afiliator')) || (request()->routeIs('afiliator-trans'))  ? 'active' : '' }}" href="{{ route('my-product-aff', $parameter) }}">My Affiliate Product</a>
            
          </div>
      </div>
  </li>

  <li class="nav-item {{ (request()->routeIs('setting'))  ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('setting',$parameter) }}">
      <i class="fas fa-fw fa-store"></i>
      <span>Setting</span></a>
  </li>

  <hr class="sidebar-divider">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->
