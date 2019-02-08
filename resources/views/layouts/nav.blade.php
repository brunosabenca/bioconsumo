<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="/">
    <i class="fa fa-carrot" aria-hidden="true"></i> BioConsumo
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar">
    @auth
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
      <li class="nav-item"><a class="nav-link" href="/orders">Group Orders</a></li>
    </ul>
    @endauth

    <!-- Authentication Links -->
    @if (Route::has('login'))
    <ul class="navbar-nav ml-a">
    @guest
      <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
    @else
      <li class="nav-item avatar dropdown">
        <a class="nav-link dropdown-toggle p-0 m-1" href="#" id="user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{asset('/images/avatars/'.auth()->user()->id.'.png')}}" class="rounded-circle z-depth-0" alt="avatar image" height="35">
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="user-dropdown">
          @can('create orders')<a class="dropdown-item" href="/user/orders/current">Current Order</a>
          <a class="dropdown-item" href="/user/orders/">Order History</a>
          <hr>
          @endcan
          <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
        </div>
      </li>
    @endguest
    </ul>
    @endif
  </div>
</nav>