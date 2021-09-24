<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">



        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('shop.cart')}}"><i class="far fa-shopping-cart mr-2"></i>Shopping Cart <span class="sr-only"></span></a>
            </li>
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user"></i>
                        {{auth()->user()->name}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('products.index')}}">Keep Shopping</a>
                        <a class="dropdown-item" href="{{route('shop.saves')}}">Saves For Later</a>
                        <form action="{{route('logout')}}" class="dropdown-item" method="post">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </li>
            @endauth
            @guest
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('login')}}"><i class="far fa-sign-in-alt mr-2"></i>Login <span class="sr-only"></span></a>
                </li>
            @endguest
        </ul>
    </div>
</nav>
