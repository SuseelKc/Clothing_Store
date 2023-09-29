    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="{{url('/')}}"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            <li class="active"><a href="{{url('/')}}">Home</a></li>
                            <!-- <li><a href="#">Women’s</a></li>
                            <li><a href="#">Men’s</a></li> -->
                            <li><a href="{{route('view_product')}}">Products</a></li>
                            <li><a href="#">Category</a>
                                <ul class="dropdown">
                                    <li><a href="./product-details.html">Women’s</a></li>
                                    <li><a href="./shop-cart.html">Men’s</a></li>
                                </ul>
                            </li>
                            <li><a href="./contact.html">Contact</a></li>
                            <li><a href="./blog.html">About Us</a></li>
                            
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__right">
                        
                        @auth
                        <div class="header__right__auth">
                            
                            <x-app-layout>
                            </x-app-layout>
                        </div>
                        @else
                        <div class="header__right__auth">
                            <a href="{{route('login')}}">Login</a>
                            <a href="{{route('register')}}">Register</a>
                        </div>
                        @endauth
                        <ul class="header__right__widget">
                            <li><span class="icon_search search-switch"></span></li>
                            <li><a href="#"><span class="icon_heart_alt"></span>
                                <div class="tip">2</div>
                            </a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span>
                                <div class="tip">2</div>
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="canvas__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>