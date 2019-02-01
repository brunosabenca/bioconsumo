<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand text-uppercase font-weight-bold" href="/">BioConsumo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar">
    @auth
    <ul class="navbar-nav mr-auto">
      <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
      <li class="nav-item"><a class="nav-link" href="/orders">Group Orders</a></li>
    </ul>
    @endauth
    <!-- Authentication Links -->
    @if (Route::has('login'))
    <ul class="navbar-nav mr-sm-2">
    @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
    @else
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }}</a>
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