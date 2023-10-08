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
    </style>
    <div class="container">
        
        <div class="row property__gallery">
            @foreach($product as $products)   
            <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $products->category->name }}">
                <div class="product__item">
             
                    <div class="product__item__pic set-bg" data-setbg="uploads/products/{{$products->image}}">
                        <ul class="product__hover">
                            <img src="uploads/products/{{$products->image}}" alt="{{$products->name}}">
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
                        <div class="product__price">Rs. {{$products->price}}</div>
                        
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