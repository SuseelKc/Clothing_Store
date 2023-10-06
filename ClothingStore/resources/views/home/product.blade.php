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
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>All products</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">All</li>
                    <li data-filter=".T-Shirt">T-Shirts</li>
                    <li data-filter=".Tentop">Tentop</li>
                    <li data-filter=".Bags">Bags</li>
                    <li data-filter=".Headbands">Headbands</li>
                    <li data-filter=".Hats">Hats</li>
                </ul>
            </div>
        </div>
        
        <div class="row property__gallery">
            @foreach($product as $products)   
            <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $products->category->name }}">
                <div class="product__item">
             
                    <div class="product__item__pic set-bg" data-setbg="uploads/products/{{$products->image}}">
                        <!-- <div class="label stockout">out of stock</div> -->
                        <!-- <div class="label">Sale</div> -->
                        <!-- <div class="label new">New</div> -->
                        <ul class="product__hover">
                            <li><a href="uploads/products/{{$products->image}}" class="image-popup"><span class="arrow_expand"></span></a></li>
                            
                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                            <li><a href="#"><span class="icon_bag_alt"></span></a></li>
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