@extends('layouts.admin')

@section('content')
 
<style>
    .box {
        padding: 5px;
        text-align: center;
        cursor: pointer;
        background-color: #f4f4f4;
        transition: background-color 0.3s;
        border-radius: 10px;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
    }

    .box h2 {
        margin: 0;
        font-size: 28px;
    }

    .box p {
        margin: 0;
        font-size: 15px;
    }

    .box:hover {
        background-color: #564949;
    }

    .box-order {
        background-color: #3498db;
        color: white;
    } 
    .box-product {
        background-color: #9e37a2;
        color: white;
    } 


    .box-bg {
        margin-bottom: 20px;
    }

    .box-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }
 
    /* request */
    .box-request{
        background-color: #6C747C;
        color: white;
    }
    .box-return{
        background-color: #39a74d;
        color: white;
    }
    .box-reject{
        background-color: #DC3545;
        color: white;
    }
    .box-approve{
        background-color: #17A3B9;
        color: white;
    }
    .box-confirm{
        background-color: #0069D9;
        color: white;
    }
    .box-cancel{
        background-color: #c94c59;
        color: white;
    }

    /* Remove box borders */
    .box {
        border: none;
    }
</style>
<div>
    @if(session('message'))
        <h2 class="alert alert-success">{{session('message')}}</h2>    
    @endif
</div>
    <div class="row">
        
        
        <div class="col-md-4 box-bg">
            <a href="{{ url('admin/category') }}">
                <div class="box box-order">
                    <i class="fas fa-code-branch box-icon"></i>
                    <h2>{{$order}}</h2>
                    <p>Orders</p>
                </div>
            </a>
        </div>  
        
        <div class="col-md-4 box-bg">
            <a href="{{ url('admin/product') }}">
                <div class="box box-product">
                    <i class="fas fa-code-branch box-icon"></i>
                    <h2>{{$product}}</h2>
                    <p>Products</p>
                </div>
            </a>
        </div>
    </div>
@endsection
   
