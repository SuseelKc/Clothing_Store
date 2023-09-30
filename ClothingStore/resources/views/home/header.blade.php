<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Amity Collection </title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="home/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="home/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="home/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="home/css/style.css" type="text/css">
</head>

<body>
<header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-2">
                    <div class="header__logo">
                        <a href="{{url('/')}}">
                            <img src="img/logo2.png" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7" style="display: flex; justify-content: center; align-items: center;">
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
                            <li><a href="">Contact</a></li>
                            <li><a href="{{route('aboutus')}}">About Us</a></li>
                            
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
                            <li><a href="{{url('/cart')}}"><span class="icon_bag_alt"></span>
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