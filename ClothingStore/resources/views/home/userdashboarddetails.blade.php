<div class="container">
    <div class="chart-container">
        <canvas id="combinedChart" width="1200" height="500"></canvas>
    </div>
</div>

<style>
    .chart-container {
        width: 1200px; /* Adjust width as needed */
        height: 500px; /* Adjust height as needed */
    }
</style>
<style>
    .no-orders-message {
        text-align: center;
        margin-top: 50px;
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

    .delivery-status {
        padding: 5px 10px;
        border-radius: 5px;
        color: #fff;
        font-weight: bold;
    }

    .delivery-status.processing {
        background-color: #FFA500; /* Orange */
    }

    .delivery-status.delivered {
        background-color: #228B22; /* Green */
    }

    .delivery-status.cancelled {
        background-color: #CA1515; /* Red */
    }

</style>

<div class="container">
    @if($orderMasters->isEmpty())
    <div class="no-orders-message">
        <h1>No orders found!</h1>
        <a href="{{ url('/products') }}" class="shop-button">Shop Items</a>
    </div>
    @else
    <h1 class="orders-title">Your Orders</h1>
    @foreach($orderMasters as $orderMaster)
    <div class="order-details">
        <div class="order-header">
            <div class="order-summary">
                <table class="table">
                    <tbody style="background-color: #F5F5DC;">
                        <tr>
                            <td><strong>Purchase Code:</strong> {{ $orderMaster->purchasecode }}</td>
                            <td><strong>Delivery Status:</strong> <span class="delivery-status {{ strtolower(\App\Enums\DeliveryStatus::getDescription($orderMaster->delivery_status)) }}">{{ \App\Enums\DeliveryStatus::getDescription($orderMaster->delivery_status) }}</span></td>
                            <td><strong>Payment Type:</strong> {{ \App\Enums\PaymentType::getDescription($orderMaster->payment_type) }}</td>
                            <td><strong>Total Amount:</strong> $ {{ $orderMaster->totalamount }}</td>
                            <td><strong>Placed order in:</strong> {{ $orderMaster->created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                @if ($orderMaster->delivery_status !== \App\Enums\DeliveryStatus::Cancelled && $orderMaster->delivery_status !== \App\Enums\DeliveryStatus::Delivered)
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
                        <img src="{{ asset($order->productImage[0]->image) }}" alt="Product Image" />
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script>
    var ctx = document.getElementById('combinedChart').getContext('2d');
    var combinedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Items in Cart', 'Total Orders', 'Cancelled Orders', 'Processing Orders', 'Delivered Orders', 'Payment in Paypal', 'Payment in Cash'],
            datasets: [{
                label: 'Count',
                // data: [{{ $countcart }}, {{ $countorder }}, {{ $countCancelledOrders }}, {{ $countProcessing}}, {{$countDelivered}}, {{$countPaypal}}, {{$countcash}}],
                data: [{{ 4 }}, {{ 8 }}, {{ 1 }}, {{ 2}}, {{6}}, {{2}}, {{5}}],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(100, 150, 200, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(231, 233, 237, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            elements: {
                point: {
                    radius: 0
                },
                line: {
                    tension: 0.4
                }
            }
        }
    });
</script>
