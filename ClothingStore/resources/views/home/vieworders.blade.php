@include('home.header')
<!-- start -->
<div class="container">
    @if($orderMasters->isEmpty())
    <h1 style="font-size: 30px; color: #CA1515; font-family: 'Cookie', cursive; padding-top:30px;">
        No orders found!
    </h1>
    <br>
    <a href="{{url('/products')}}" class="hover-button" style="display: inline-block; padding: 10px 20px; font-size: 16px; text-decoration: none; color: #CA1515; border: 2px solid #CA1515; border-radius: 5px; transition: background-color 0.3s, color 0.3s;">
        Shop Items
    </a>
    @else
    <h1>Your Orders</h1>
    @foreach($orderMasters as $key => $orderMaster)
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Purchase Code</th>
                <th>Total Amount</th>
                <th>Delivery Status</th>
                <th>Payment Type</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $orderMaster->purchasecode }}</td>
                <td>{{ $orderMaster->totalamount }}</td>
                <td>{{ $orderMaster->delivery_status }}</td>
                <td>{{ $orderMaster->payment_type }}</td>
            </tr>
        </tbody>
    </table>
    <!-- Display Order items associated with this OrderMaster -->
    <table class="table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderMaster->orders as $order)
            <tr>
                <td>{{ $order->product_id }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ $order->rate }}</td>
                <td>{{ $order->amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
    @endif
</div>
<!-- end -->
@include('home.footer')
