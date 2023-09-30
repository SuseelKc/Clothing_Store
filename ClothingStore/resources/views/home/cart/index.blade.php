@include('home.header')


 
<div class="container">
    <h6>Cart of {{auth()->user()->name}}</h6>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    
                    <div class="card-body table-responsive p-2">
                        <table class="datatable table">
                            <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Rate</th>
                                        <th>Quantity</th>
                                        <th>Image</th>
                                        
                                    </tr>
                            </thead>
                            <tbody>
                                    @foreach($cart as $cart)

                                    
                                    <tr>
                                        <td>{{$cart->id}}</td>
                                        <td>{{$cart->product->name}}</td>
                                        <td>{{$cart->rate}}</td>
                                        <td>{{$cart->quantity}}</td>
                                        <td>
                                            @if($cart->image)
                                            <img 
                                            src="{{asset('/uploads/cart/'.$cart->image)}}"
                                            style="width: 80px; height:80px;" alt="No image"/>
                                            @else
                                            <h5>No Image</h5>
                                            @endif 
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@include('home.footer')