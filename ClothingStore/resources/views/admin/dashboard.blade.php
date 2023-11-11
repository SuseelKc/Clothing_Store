@extends('layouts.admin')

@section('content')
 
<style>
    .box-link {
        text-decoration: none !important; /* Remove underline from anchor links */
        color: white; /* Inherit text color from parent */
    }

    .box-bg {
        background-color: #fff;
        border-radius: 10px; /* Smaller border-radius for a more square shape */
        padding: 5px; /* Reduced padding */
        text-align: center;
        transition: background-color 0.3s ease-in-out;
        width: 100%; /* Adjust the width to 100% to fill the column */
        height: 100%; /* Adjust the height to 100% to fill the column */
        display: flex;
        justify-content: center;
        align-items: center;
        
        
    }

    .box-content {
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }

    .orders-box {
        background-color: #f0ad4e; /* Yellowish color for Orders box */
    }

    .products-box {
        background-color: #5bc0de; /* Blueish color for Products box */
    }

    .category-box {
        background-color: #489a68; /* Blueish color for Products box */
    }

    .box-bg:hover {
        background-color: #e0a7a7; /* Red color on hover */
    }

    .menu-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }

    h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    p {
        font-size: 18px;
    }
    .col-md-4{
        width: 50px;
    }
    .user-box {
        background-color: #b959a4;
}
    .processing-box{
        background-color: #3b5ca9;
    }
    .delivered-box{
        background-color: #3dc436;
    }
    .cancelled-box{
        background-color: #ec482b;
    }
    .totalrevenue-box{
        background-color: #9daf22;
    }

</style>

<div>
    @if(session('message'))
        <h2 class="alert alert-success">{{session('message')}}</h2>    
    @endif
</div>
<div class="row">
    <div class="col-md-4">
        <a href="{{ url('admin/order') }}" class="box-link">
            <div class="box-bg orders-box">
                <div class="box-content">
                    <i class="mdi mdi-shopping menu-icon"></i>
                    <h2>{{ $order }}</h2>
                    <p>Orders</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ url('admin/product') }}" class="box-link">
            <div class="box-bg products-box">
                <div class="box-content">
                    <i class="mdi mdi-package-variant-closed menu-icon"></i>
                    <h2>{{ $product }}</h2>
                    <p>Products</p>
                </div>
            </div>
        </a>
    </div>
    {{-- category --}}
    <div class="col-md-4">
        <a href="{{ url('admin/category') }}" class="box-link">
            <div class="box-bg category-box">
                <div class="box-content">
                    <i class="mdi mdi-view-list menu-icon"></i>
                    <h2>{{ $category }}</h2>
                    <p>Category</p>
                </div>
            </div>
        </a>
    </div>
    {{--  --}}
    {{-- users --}}
    <div class="col-md-4" style="padding-top:20px;">
        <a href="{{url('admin/userview')}}" class="box-link">
            <div class="box-bg user-box">
                <div class="box-content">
                    <i class="mdi  mdi-account-multiple menu-icon"></i>
                    <h2>{{ $user }}</h2>
                    <p>Users</p>
                </div>
            </div>
        </a>
    </div>
    {{-- processing orders --}}
    <div class="col-md-4" style="padding-top:20px;">
        <a href="" class="box-link">
            <div class="box-bg processing-box">
                <div class="box-content">
                    <i class="mdi  mdi-clock menu-icon"></i>
                    <h2>{{ $processing }}</h2>
                    <p>Processing orders</p>
                </div>
            </div>
        </a>
    </div>
    {{-- Delivered --}}
    <div class="col-md-4" style="padding-top:20px;">
        <a href="" class="box-link">
            <div class="box-bg delivered-box">
                <div class="box-content">
                    <i class="mdi  mdi-account-check menu-icon"></i>
                    <h2>{{ $delivered }}</h2>
                    <p>Delivered</p>
                </div>
            </div>
        </a>
    </div>
    {{-- cancelled --}}
    <div class="col-md-4" style="padding-top:20px;">
        <a href="" class="box-link">
            <div class="box-bg cancelled-box">
                <div class="box-content">
                    <i class="mdi mdi-account-remove menu-icon"></i>
                    <h2>{{ $cancelled }}</h2>
                    <p>Cancelled</p>
                </div>
            </div>
        </a>
    </div>
    {{-- totalrevenue --}}
    <div class="col-md-4" style="padding-top:20px;">
        <a href="" class="box-link">
            <div class="box-bg totalrevenue-box">
                <div class="box-content">
                    <i class="mdi mdi-cash-usd menu-icon"></i>
                    <h2>$ {{ $totalrevenue }}</h2>
                    <p>Total Revenue</p>
                </div>
            </div>
        </a>
    </div>

</div><br><br>
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h3><b>Chart for Order Processing, Delivered, and Cancelled</b></h3><br>
<div class="row">
    <div class="col-md-6">
        <canvas id="combinedChart" width="300" height="300"></canvas>
    </div>
</div>


<!-- JavaScript script for creating a combined pie chart -->
<script>
    // Data for pie chart
    var processingData = {{ $processing }};
    var deliveredData = {{ $delivered }};
    var cancelledData = {{ $cancelled }};
    var remainingData = {{ $order - $processing - $delivered - $cancelled }};

    // Create a combined pie chart
    var combinedChart = new Chart(document.getElementById('combinedChart'), {
        type: 'pie',
        data: {
            labels: ['Processing', 'Delivered', 'Cancelled', 'Remaining'],
            datasets: [{
                data: [processingData, deliveredData, cancelledData, remainingData],
                backgroundColor: ['#3b5ca9', '#3dc436', '#ec482b', '#f0f0f0'],
            }],
        },
    });
</script>


@endsection
   
