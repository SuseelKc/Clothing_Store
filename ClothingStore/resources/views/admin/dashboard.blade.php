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
        background-color: #58cc58; /* Blueish color for Products box */
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

    </div>
    {{--  --}}
</div>

@endsection
   
