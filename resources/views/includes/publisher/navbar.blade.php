<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('dashboard') }}">
      <img src="{{ url('image/navbar/navbar_brand.png') }}" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="input-group mr-5">
      <input 
        type="text"
        id="inputSearchBar"
        class="form-control" 
        placeholder="Apa yang sedang anda cari?"
        aria-label="Amount (to the nearest dollar)">
      <div class="input-group-append">
        <span class="input-group-text">
          <i class="fa fa-search"></i>
        </span>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('wishlist') }}">
            <img 
              src="{{ url('image/navbar/ic_heart.png') }}" 
              alt=""
              class="icon">
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('cart') }}">
            <img 
              src="{{ url('image/navbar/ic_cart.png') }}" 
              alt=""
              class="icon">
          </a>
        </li>
        <div class="separator" id="navbarSeparator"></div>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $firstName }}
            <img 
              src="{{ url('image/navbar/ic_account.png') }}" 
              alt=""
              class="icon">
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('dashboard') }}">Buku Saya</a>
            <a class="dropdown-item" href="{{ route('dashboard') }}">Menu Buyer</a>
            <a class="dropdown-item" href="{{ route('orders') }}">Pesanan Saya</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="" id="linkLogout">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>