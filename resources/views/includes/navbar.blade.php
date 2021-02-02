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
          <li><a href="{{ route('categories') }}">Categories</a></li>
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
              <li class="{{ (request()->routeIs('profil')) ? 'active' : '' }}"><a href="{{ route('profil', $parameter) }}">Akun Saya</a></li>
              @if($slug)
              <li class="{{ (request()->routeIs('profil-toko')) ? 'active' : '' }}"><a href="{{ route('profil-toko', $slug) }}">Profil Toko</a></li>
              @else
              <li class="{{ (request()->routeIs('profil-toko')) ? 'active' : '' }}"><a  data-target="#seller" data-toggle="modal" data-url="" data-id="" href="">Profil Toko</a></li>
              @endif

              @if(Auth::user()->address_one)
              <li class="{{ (request()->routeIs('seller')) ? 'active' : '' }}"><a href="{{ route('seller', $parameter) }}">Seller</a></li>
              @else
              <li class="{{ (request()->routeIs('seller')) ? 'active' : '' }}"><a  data-target="#seller" data-toggle="modal" data-url="" data-id="" href="">Seller</a></li>
              @endif
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
      @auth
      <div id="seller" class="modal fade myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    Lengkapi data diri Anda sebelum membuka halaman seller
                </div>
                <div class="modal-footer">
                  <a  style="margin-left:auto;margin-right:auto;" href="{{ route('profil', $parameter) }}" class="btn btn-success">Go To Setting Profil</a>
                </div>
            </div>
        </div>
      </div>
      @endauth
      

    </div>
  </header><!-- End Header -->