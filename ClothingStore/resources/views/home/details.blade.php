<!DOCTYPE html>
<html lang="zxx">

<head>
    <base href="/public">
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ashion | Template</title>

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
    <style>
        /* Styles for the product details section */
        .hero_area {
            background-image: url('home/images/your-background-image.jpg'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;
            padding: 80px 0;
        }

        .product-details {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .product-image img {
            max-width: 100%; /* Ensure the image does not exceed the container's width */
            max-height: 300px; /* Set a maximum height for the image */
            display: block; /* Remove extra space below inline images */
            margin: 0 auto; /* Center the image horizontally */
        }

        .product-title {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 18px;
            color: blue;
        }

        .original-price {
            text-decoration: line-through;
            color: red;
        }

        .product-category {
            font-size: 16px;
        }

        .product-description {
            font-size: 16px;
            margin-top: 20px;
        }

        .product-quantity {
            font-size: 16px;
            margin-top: 20px;
        }

        .add-to-cart-btn {
            margin-top: 20px;
        }

    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    @include('home.header')
    <!-- Header Section End --> 

    <div class="hero_area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-4 mx-auto">
                    <div class="product-details">
                        <form 
                            action="{{url('admin/product/'.$product->id.'/cart')}}"
                             method="get" enctype="multipart/form-data">
                            @csrf

                            {{-- user --}}
                            @auth
                            <input name="user_id" value="{{auth()->user()->id}}" style="display: none;"/>
                            @endauth
                               {{--  Image--}}
                                <div class="product-image">
                                    {{--  --}}
                                    <input type="file" name="image" class="form-control" value="{{$product->image}}"  style="display: none;"/>
                                    {{--  --}}
                                    <img src="/uploads/products/{{$product->image}}" alt="Product Image">
                                </div>

                                {{-- product title --}}
                                <div class="product-title">
                                    <input type="text" name="name" class="form-control" value="{{$product->name}}" style="display: none;"/>
                                    {{$product->name}}
                                </div>

                                {{-- product id --}}
                                <div class="product_id">
                                    <input type="number" name="product_id" value="{{$product->id}}" style="display: none;" />
                                </div>
                                {{--  --}}

                                {{--  --}}
                                <div class="product-price">
                                    @if($product->discounted_price != null)
                                    {{--  --}}
                                    <input type="number" name="price" class="form-control" value="{{$product->discounted_price}}" style="display: none;"/>
                                    {{--  --}}
                                    Discounted Price: Rs. {{$product->discounted_price}}
                                    @else
                                    {{--  --}}
                                    <input type="number" name="price" class="form-control" value="{{$product->price}}" style="display: none;"/>
                                    {{--  --}}
                                        Price: Rs. {{$product->price}}
                                    @endif
                                </div>

                                @if($product->discounted_price != null)
                                    <div class="original-price">
                                        Original Price: Rs. {{$product->price}}
                                    </div>
                                @endif
                                <div class="product-category">
                                    Category: {{$product->category->name}}
                                    {{-- <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{$product->category->name}}
                                    </option> --}}
                                </div>
                                <div class="product-description">
                                    Description: {{$product->description}}
                                    {{--  --}}
                                    <input type="text" name="description" class="form-control" value="{{$product->description}}" style="display: none;"/>
                                    {{--  --}}
                                </div>
                                <div class="product-quantity">
                                    Available Quantity: {{$product->quantity}}
                                </div>
                            
                                &nbsp;
                                    <div class="row">
                                        <div class="col-md-4">
                                        <input type="number" name="quantity" value="1" min="1" value="{{$product->quantity}}"  style="width: 100px;">
                                        </div>
                                        &nbsp;
                                        <div class="col-md-4">
                                        <input type="submit" class="btn btn-danger" style="background-color:red;" value="Add To Cart">
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <button  type="submit" class="btn btn-danger" style="background-color:red;" >Add To Cart</button>    
                                        </div> --}}

                                    </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Footer Section Begin -->
@include('home.footer')
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search End -->
<!-- Js Plugins -->
<script src="home/js/jquery-3.3.1.min.js"></script>
<script src="home/js/bootstrap.min.js"></script>
<script src="home/js/jquery.magnific-popup.min.js"></script>
<script src="home/js/jquery-ui.min.js"></script>
<script src="home/js/mixitup.min.js"></script>
<script src="home/js/jquery.countdown.min.js"></script>
<script src="home/js/jquery.slicknav.js"></script>
<script src="home/js/owl.carousel.min.js"></script>
<script src="home/js/jquery.nicescroll.min.js"></script>
<script src="home/js/main.js"></script>

</body>

</html>
