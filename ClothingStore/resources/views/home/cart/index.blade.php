@include('home.header')


 
<div class="container">
    <style>
        /* Normal state styles */
a.hover-button {
    background-color: transparent;
    border: 2px solid #CA1515;
    color: #CA1515;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

/* Hover state styles */
a.hover-button:hover {
    background-color: #CA1515;
    color: white;
}
h6.bold-and-big {
    /* font-weight: bold; */
    font-family: 'Cookie', cursive;
    font-size: 50px; /* You can adjust the size as needed */
}
    </style>
    <h6 class="bold-and-big">Cart</h6>


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    
                    <div class="card-body table-responsive p-2">
                        <table class="datatable table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @php
                                $counter = 1;
                                $totalAmount = 0; // Initialize total amount
                                @endphp
                                @foreach($cart as $cart)
                                @if((auth()->user()->id) == ($cart->user_id))
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>
                                        <img src="{{asset('uploads/products/'.$cart->product->image)}}" style="height:90px; width:90px"
                                            alt="No images" />
                                    </td>
                                    <td>{{$cart->product->name}}</td>
                                    <td>{{$cart->rate}}</td>
                                    <td>{{$cart->quantity}}</td>
                                    <td>{{$cart->price}}</td>
                                    <td>
                                        <a
                                        href="{{url('cart/'.$cart->id.'/delete')}}" 
                                        class="btn btn-danger btn-sm text-white">Remove</a>
                                    </td>
                                </tr>
                                @php
                                $counter++;
                                $totalAmount += $cart->price; // Add the item's price to the total amount
                                @endphp
                                @else
                                {{-- <h1>No Product Added</h1> --}}
                                @endif
                                @endforeach
                                <tr>
                                    <td colspan="7">
                                        @if ($counter == 1)
                                        <h1>No Product Added!</h1>
                                        <br>
                                        <a href="{{url('/products')}}" class="hover-button">
                                            Shop Items
                                        </a>                                      
                                        @else
                                        <div class="text-right" style="padding-right:250px;">
                                            <strong>Total Amount:</strong> Rs. {{$totalAmount}} 
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@include('home.footer')