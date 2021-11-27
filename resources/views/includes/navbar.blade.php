<header id="header">
    <div class="container d-flex">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="{{ route('/') }}">TOKO ONLINE</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="{{ route('categories') }}">Kategori</a></li>

          @guest
          <li><a href="{{ url('login') }}">Login</a></li>
          @endguest
          
          @guest
          <li class="{{ (request()->routeIs('cart')) ? 'active' : '' }}"><a href="{{ route('login') }}"><i class="fa fa-shopping-cart "></i></a></li>
          @endguest

          @auth
          <li class="drop-down {{ (request()->routeIs('profil') ||  request()->routeIs('seller')) ? 'active' : '' }}"><a href="#">Hi, {{ Auth::user()->name }}</a>
            <ul>
              <?php
                  $parameter= Crypt::encrypt(Auth::user()->id);
                  $slug= Auth::user()->slug;
              ?>
              <li class="{{ (request()->routeIs('profil')) ? 'active' : '' }}"><a href="{{ route('profil', $parameter) }}">Akun Saya</a></li>
              
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
          

          @auth
            @if(Auth::user()->provinces_id && Auth::user()->regencies_id)
            <?php
              $total_cart= cart::where('users_id', Auth::user()->id)->count();
            ?>
              @if($total_cart > 0)
              <li><a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i><span class='badge badge-warning' id='lblCartCount'> {{ $total_cart }} </span></a></li>
              @else
              <li><a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a></li>
              @endif
            @else
            <li><a data-target="#seller" data-toggle="modal" data-url="" data-id="" href=""><i class="fa fa-shopping-cart"></i></a></li>
            @endif
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
                    Lengkapi data diri Anda sebelum melihat keranjang
                </div>
                <div class="modal-footer">
                  <a  style="margin-left:auto;margin-right:auto;" href="{{ route('profil', $parameter) }}" class="btn btn-success">Atur Profil</a>
                </div>
            </div>
        </div>
      </div>
      @endauth
      

    </div>
  </header><!-- End Header -->