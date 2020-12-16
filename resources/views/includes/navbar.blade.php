<header id="header">
    <div class="container d-flex">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="{{ route('/') }}">MARKETPLACE</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="{{ (request()->routeIs('/')) ? 'active' : '' }}"><a href="{{ route('/') }}">Home</a></li>
          <li><a href="">Categories</a></li>
          @guest
          <li class="{{ (request()->routeIs('cart')) ? 'active' : '' }}"><a href="{{ route('login') }}"><i class="fa fa-shopping-cart"></i></a></li>
          @endguest
          @auth
          <li><a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a></li>
          @endauth
          
          @guest
          <li><a href="{{ url('login') }}">Login</a></li>
          @endguest

          @auth
          <li class="drop-down {{ (request()->routeIs('profil') || request()->routeIs('profil-toko') || request()->routeIs('seller')) ? 'active' : '' }}"><a href="#">Hi, {{ Auth::user()->name }}</a>
            <ul>
              <?php
                  $parameter= Crypt::encrypt(Auth::user()->id);
                  $slug= Auth::user()->slug;
              ?>
              <li class="{{ (request()->routeIs('profil')) ? 'active' : '' }}"><a href="{{ route('profil', $parameter) }}">Profil</a></li>
              @if($slug)
              <li class="{{ (request()->routeIs('profil-toko')) ? 'active' : '' }}"><a href="{{ route('profil-toko', $slug) }}">Profil Toko</a></li>
              @else
              <li class="{{ (request()->routeIs('profil-toko')) ? 'active' : '' }}"><a href="{{ route('profil', $parameter) }}">Profil Toko</a></li>
              @endif
              <li class="{{ (request()->routeIs('seller')) ? 'active' : '' }}"><a href="{{ route('seller', $parameter) }}">Seller</a></li>
              <li>
                <form  action="{{ url('logout') }}" method="POST">
                  @csrf
                  <button class="btn btn-login my-2 my-sm-0" type='submit'>
                    Keluar
                  </button>
                </form>
              </li>
            </ul>
          </li>
          @endauth 

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->