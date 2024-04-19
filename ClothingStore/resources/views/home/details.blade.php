<!DOCTYPE html>
<html lang="zxx">

<head>
    <base href="/public">
    <meta charset="UTF-8">
    <meta name="description" content="Ashion Template">
    <meta name="keywords" content="Ashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Amity Collections</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('home/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('home/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('home/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('home/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('home/css/magnific-popup.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('home/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('home/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('home/css/style.css')}}" type="text/css">
    <!-- ExZoom CSS -->
    <link href="{{asset('assets/exzoom/jquery.exzoom.css')}}" rel="stylesheet">
    

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
            max-height: 100%; /* Set a maximum height for the image */
            display: block; /* Remove extra space below inline images */
            margin: 0 auto; /* Center the image horizontally */
        }

        .product-title {
            color: black;
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
        .product {
    position: relative;
}

.product-hover {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
}

.product-image:hover .product-hover {
    display: block;
}

.details-button {
    background: #ff5722;
    color: #fff;
    padding: 5px 10px;
    text-align: center;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    display: inline-block;
    text-decoration: none;
    
}
.similar-products-heading {
    font-size: 28px; /* Adjust the font size as needed */
    color: #333; /* Change the color to your preference */
    text-align: center; /* Center the text */
    margin-top: 20px; /* Add some top margin for spacing */
    font-weight: bold; /* Make the text bold if desired */
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
                <div class="col-md-6">
                    <div class="product-image">
                        {{-- Product Image --}}
                        @if($product->productImage)
                        {{-- <img src="{{asset($product->productImage[0]->image)}}"  alt="Product Image"> --}}
                        <div class="exzoom" id="exzoom">
                            <!-- Images -->
                            <div class="exzoom_img_box">
                              <ul class='exzoom_img_ul'>
                                @foreach ($product->productImage as $images)
                                    <li><img src="{{asset($images->image)}}"/></li>
                                @endforeach
                                
                              </ul>
                            </div>
                            <!-- <a href="https://www.jqueryscript.net/tags.php?/Thumbnail/">Thumbnail</a> Nav-->
                            <div class="exzoom_nav"></div>
                            <!-- Nav Buttons -->
                            <p class="exzoom_btn">
                                <a href="javascript:void(0);" class="exzoom_prev_btn"> < </a>
                                <a href="javascript:void(0);" class="exzoom_next_btn"> > </a>
                            </p>
                        </div>

                        @else
                            No Image Added
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-details">
                        <form 
                            action="{{url('product/'.$product->id.'/cart')}}"
                            method="get" enctype="multipart/form-data">
                            @csrf
                            {{-- User --}}
                            @auth
                                <input name="user_id" value="{{auth()->user()->id}}" style="display: none;">
                            @endauth

                            {{-- Product title --}}
                            <div class="custom-box" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px;">
                                <b><h3 class="text-primary">Product Name: {{$product->name}}</h3></b>
                            </div>

                            {{-- Product Price --}}
                            <div class="custom-box" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                <h4 class="text-info">
                                    @if($product->discounted_price != null)
                                    {{-- Display Discounted Price --}}
                                    <span class="original-price">Original Price: $ {{$product->price}}</span><br>
                                    Discounted Price: $ {{$product->discounted_price}}
                                    @else
                                    {{-- Display Original Price --}}
                                    Price: $ {{$product->price}}
                                    @endif
                                </h4>
                            </div>

                            {{-- Product Category --}}
                            <div class="custom-box" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                <p class="text-muted">Category: {{$product->category->name}}</p>
                            </div>

                            {{-- Product Description --}}
                            <div class="custom-box" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                <p>{{$product->description}}</p>
                            </div>

                            {{-- Product Quantity and Add to Cart Button --}}
                            <div class="custom-box" style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                <p class="text-secondary">Available Quantity: {{$product->quantity}}</p>
                                @if(session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                {{-- Size Dropdown --}}
                                @if($product->sizes->isNotEmpty())
                                    <div class="size">
                                        <label for="sizeDropdown">Size Available:</label>
                                        <select id="sizeDropdown" name="selectedSize" required>
                                            <option value="" disabled selected>Select Size</option>
                                            @foreach ($product->sizes as $size)
                                                <option value="{{$size->id}}">{{$size->size}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <br>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" name="quantity" value="1" min="1" value="{{$product->quantity}}" style="width: 100px;" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="submit" class="btn btn-danger" style="background-color: red;" value="Add To Cart">
                                    </div>
                                </div>
                        
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Other Products Section -->
<div class="container">
    <div class="row">
        @if(count($relatedProducts) > 0)
        <div class="col-md-12">
            <h2 class="similar-products-heading">Similar Products</h2>
        </div>
        @endif
    </div>
    <div class="row">
        @foreach($relatedProducts as $relatedProduct)
            <div class="col-md-3">
                <div class="product">
                    <a href="{{ route('product_details', ['id' => $relatedProduct->id]) }}">
                        <div class="product-image">
                            @if($relatedProduct->productImage->isNotEmpty())
                            <img src="{{ asset($relatedProduct->productImage[0]->image) }}" alt="Product Image">
                            @else
                            <img src="img/NoImage.jpg" alt="Alternative Text" >
                            @endif
                            <div class="product-hover">
                                <a href="{{ route('product_details', ['id' => $relatedProduct->id]) }}" class="details-button">Details</a>
                            </div>
                        </div>
                        <a href="{{ route('product_details', ['id' => $relatedProduct->id]) }}" class="product-title">
                            {{ $relatedProduct->name }}
                        </a> 
                        <div class="product-price">
                            @if($relatedProduct->discounted_price != null)
                                <div class="original-price">
                                Original Price: $ {{$relatedProduct->price}}
                                </div>
                                Offer Price: $ {{ $relatedProduct->discounted_price }}
                            @else
                                Price: $ {{ $relatedProduct->price }}
                            @endif
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
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
 <!-- Scripts -->
 <script src="{{asset('home/js/jquery-3.3.1.min.js')}}"></script>
 <script src="{{asset('home/js/bootstrap.min.js')}}"></script>
 <script src="{{asset('home/js/jquery.magnific-popup.min.js')}}"></script>
 <script src="{{asset('home/js/jquery-ui.min.js')}}"></script>
 <script src="{{asset('home/js/mixitup.min.js')}}"></script>
 <script src="{{asset('home/js/jquery.countdown.min.js')}}"></script>
 <script src="{{asset('home/js/jquery.slicknav.js')}}"></script>
 <script src="{{asset('home/js/owl.carousel.min.js')}}"></script>
 <script src="{{asset('home/js/jquery.nicescroll.min.js')}}"></script>
 <!-- ExZoom JavaScript -->
 <script src="{{asset('assets/exzoom/jquery.exzoom.js')}}"></script>

   
<script>
    $(function(){
  
              $("#exzoom").exzoom({
  
              "navWidth": 60,
              "navHeight": 60,
              "navItemNum": 5,
              "navItemMargin": 7,
              "navBorder": 1,
  
              // autoplay
              "autoPlay": false,
  
              // autoplay interval in milliseconds
              "autoPlayTimeout": 2000
              
              });
  
            });

            $(window).on('load', function() {
                // Hide the loader when everything on the page has finished loading
                $('#preloder').fadeOut();
            });    
  </script>
  
</body>



</html>