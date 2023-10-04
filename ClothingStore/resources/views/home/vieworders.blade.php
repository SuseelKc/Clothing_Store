@include('home.header')

<div class="container">
    @if(count($order) > 0)
    <h1>Your Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Purchase Code</th>
                <th>Total Amount</th>
                <th>Delivery Status</th>
                <th>Payment Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order as $key => $orderItem)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $orderItem->user_id }}</td>
                <td>{{ $orderItem->purchasecode }}</td>
                <td>{{ $orderItem->totalamount }}</td>
                <td>{{ $orderItem->delivery_status }}</td>
                <td>{{ $orderItem->payment_type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h1 style="font-size: 30px; color: #CA1515; font-family: 'Cookie', cursive; padding-top:30px;">
        No orders found!
    </h1>
    <br>
    <a href="{{url('/products')}}" class="hover-button" style="display: inline-block; padding: 10px 20px; font-size: 16px; text-decoration: none; color: #CA1515; border: 2px solid #CA1515; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
        Shop Items
    </a>
    @endif
</div>

@include('home.footer')
