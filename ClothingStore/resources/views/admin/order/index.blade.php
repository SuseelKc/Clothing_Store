@extends('layouts.admin')

@section('content')

<div class="row">

    <style>
        /* Add borders to table, table header, and table cells */
        table {
            border-collapse: collapse; /* Collapse borders to avoid double borders */
            width: 100%; /* Optional: Make the table full width of its container */
        }
    
        th, td {
            border: 1px solid #ddd; /* Add a 1px solid border to table header and cells */
            padding: 8px; /* Add some padding for better spacing */
            text-align: left; /* Optional: Align text to the left within cells */
        }
    
        /* Style the table header row */
        th {
            background-color: #f2f2f2; /* Add a background color to the header row */
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css">


    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3> Orders
                    {{-- <a 
                    href="{{route('product.create')}}" 
                    class="btn btn-primary btn-sm text-white float-right">Add Product</a> --}}
                </h3>
            </div>
                <div class="card-body">
                <div class="card-body table-responsive p-2">    

                    <table class="datatable table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>OrderNo.</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Payment Type</th>
                                <th>Action</th>
                              
                            </tr>   
                        </thead>
                        <tbody>
                            @foreach($orders as $order)

                            
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->purchasecode}}</td>
                                <td>{{$order->totalamount}}</td>
                                <td>{{ \App\Enums\DeliveryStatus::getDescription($order->delivery_status) }}</td>
                                <td>{{\App\Enums\PaymentType::getDescription($order->payment_type)}}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm text-white">Details</button>
                                    <button class="btn btn-success btn-sm text-white">Delivered</button>
                                    <button class="btn btn-danger btn-sm text-white">Cancel Order</button>
                                </td>
                            </tr>
                            @endforeach
                            
                            

                        </tbody>
                    


                    </table>

                
                </div>
                <br>
                {{-- <div class="pagination float-right"
        >{{$products->links()}}</div> --}}
            


        </div>

        
    </div>

</div>

@endsection