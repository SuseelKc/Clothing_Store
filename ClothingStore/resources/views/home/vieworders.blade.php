@include('home.header')

<style>
    /* CSS Styles for Orders Page */
    .no-orders-message {
        font-size: 30px;
        color: #CA1515;
        font-family: 'Cookie', cursive;
        padding-top: 30px;
    }

    .shop-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-decoration: none;
        color: #CA1515;
        border: 2px solid #CA1515;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .orders-title {
        font-size: 24px;
        color: #333;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .order-details {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 30px;
        background-color: #fff;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .order-summary {
        width: 60%;
    }

    .order-summary th,
    .order-summary td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .order-items {
        width: 100%;
    }

    .order-items th,
    .order-items td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .order-items img {
        max-height: 100px;
        max-width: 100px;
    }

    .cancel-button {
        background-color: #CA1515;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        text-decoration: none;
    }

    .cancel-button:hover {
        background-color: #FF0000;
    }
</style>

<div class="container">
    @if($orderMasters->isEmpty())
    <h1 class="no-orders-message">
        No orders found!
    </h1>
    <br>
    <a href="{{ url('/products') }}" class="hover-button shop-button">
        Shop Items
    </a>
    @else
    <h1 class="orders-title" style="padding-top:20px;">Your Orders</h1>
    @foreach($orderMasters as $key => $orderMaster)
    <div class="order-details">
        <div class="order-header">
            <div class="order-summary">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Purchase Code: {{ $orderMaster->purchasecode }}</td>
                            <td>Delivery Status: <span style="background-color: lightblue;">{{ \App\Enums\DeliveryStatus::getDescription((int) $orderMaster->delivery_status) }}</span></td>
                            <td>Payment Type: {{ \App\Enums\PaymentType::getDescription((int) $orderMaster->payment_type) }}</td>
                            <td>Total Amount: $ {{ $orderMaster->totalamount }}</td>
                            <td>Placed order in: {{ $orderMaster->created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                @if ((int) $orderMaster->delivery_status !== \App\Enums\DeliveryStatus::Cancelled && (int) $orderMaster->delivery_status !== \App\Enums\DeliveryStatus::Delivered)
                    <a href="{{ route('cancel_order', $orderMaster->id) }}" class="cancel-button">Cancel Order</a>
                @endif
            </div>
            
        </div>

        <!-- Display Order items associated with this OrderMaster -->
        <table class="table order-items">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderMaster->orders as $order)
                <tr>
                    <td>
                        @if($order->productImage->isNotEmpty())
                        <img 
                        src="{{ asset($order->productImage[0]->image) }}"
                        {{-- src="{{asset('uploads/products/'.$order->productImage[0]->image)}}"  --}}
                        alt="Product Image" />
                        @else
                         No Image Available
                        @endif
                    </td>
                    <td>{{ $order->product->name }}</td>
                    <td>
                        @if ($order->sizes)
                            {{ $order->sizes->size }}
                        @else
                            No Size Available
                        @endif
                    </td>
                    <td>{{ $order->quantity }}</td>
                    <td>$ {{ $order->rate }}</td>
                    <td>$ {{ $order->amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
    @endif
</div>

@include('home.footer')
