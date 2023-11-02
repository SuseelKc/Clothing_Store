@include('home.header')
<section class="product spad">
    <style>
/* CSS to hide the "Details" button by default */
.details-button {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #ff5722;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* CSS to show the "Details" button on hover */
.product__item:hover .details-button {
    display: block;
    opacity: 1;
}

/* Style the "Details" button (you can customize this further) */
.details-button a {
    text-decoration: none;
    color: inherit;
}
 /* Default button styles */
 .btn-primary {
            background-color: transparent;
            border: 2px solid #007bff; /* Blue border color */
            color: #000; /* Black text color */
            border-radius: 20px;
            margin-left: 12px;
            transition: background-color 0.3s, color 0.3s;
        }
    
/* Button styles on hover */
.btn-primary:hover {
    background-color: #007bff; /* Blue background color */
    color: #fff; /* White text color */
}
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">

    <div class="container">
        <div class="col-lg-4 col-md-4">
            <div class="search-bar" style="text-align: right;">
                <form action="{{ route('search_products') }}" method="GET">
                    @csrf
                    <div class="input-group" style="max-width: 300px; margin: 0 auto;">
                        <input type="text" class="form-control" name="query" placeholder="Search products..." style="border-radius: 20px;">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" style="border-radius: 20px; margin-left:12px;">
                                <i class="mdi mdi-magnify menu-icon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div><br>
        <div class="row property__gallery">

            @foreach($product as $products)   
            <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $products->category->name }}">
                <div class="product__item">
             
                    <div class="product__item__pic set-bg" data-setbg="uploads/products/{{$products->image}}">
                        <ul class="product__hover">
                            @if($products->productImage->isNotEmpty())
                            <img 
                            src="{{ asset($products->productImage[0]->image) }}"
                            {{-- src="uploads/products/{{$products->productImage[0]->image}}" --}}
                             alt="{{$products->name}}">
                            @else
                             <img src="img/NoImage.jpg">
                            @endif 
                        </ul>
                        <!-- Details button (hidden by default) -->
                        <a href="{{route('product_details',$products->id)}}" class="details-button">Details</a>
                        <!-- <div class="details-button">Details</div> -->
                    </div>
                    
                    <div class="product__item__text">
                        <h6><a href="{{route('product_details',$products->id)}}">{{$products->name}}</a></h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="product__price">$ {{$products->price}}</div>
                        
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div  class="pagination" style="float: right;">
            {{$product->links()}}
        </div>
        
    </div>

</section>
@include('home.footer')