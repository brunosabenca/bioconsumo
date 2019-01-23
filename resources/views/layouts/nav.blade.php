<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand text-uppercase font-weight-bold" href="/">BioConsumo</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="products-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
        <div class="dropdown-menu" aria-labelledby="products-dropdown">
          <a class="dropdown-item" href="/products">List all</a>
          <a class="dropdown-item" href="/products/create">Create new</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="orders-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Group Orders</a>
        <div class="dropdown-menu" aria-labelledby="orders-dropdown">
          <a class="dropdown-item" href="/orders">List all</a>
          <a class="dropdown-item" href="/orders/create">Create new</a>
        </div>
      </li>
      @auth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">User</a>
        <div class="dropdown-menu" aria-labelledby="orders-dropdown">
          <a class="dropdown-item" href="/user/order">Order</a>
          <a class="dropdown-item" href="/user/orders">List all</a>
        </div>
      </li>
      @endauth
    </ul>
    <!-- Authentication Links -->
    <ul class="navbar-nav mr-sm-2">
    @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
    @else
          <li class="nav-item"><a class="nav-link" href="#">{{ auth()->user()->name }}</a></li>
    @endguest
    </ul>
  </div>
</nav>