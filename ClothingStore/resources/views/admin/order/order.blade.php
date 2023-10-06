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
                <h3> Order
                    
                    <a 
                    href="{{route('order.index')}}" 
                    class="btn btn-primary btn-sm text-white float-right">Back</a>
                 
                </h3>
            </div>
                <div class="card-body">
                    <div class="row float-right">
                        <a 
                        {{-- href="{{route('product.create')}}"  --}}
                        class="btn btn-success btn-sm text-white float-right">Delivered</a>
                        &nbsp;&nbsp;&nbsp;
                        <a 
                        {{-- href="{{route('product.create')}}"  --}}
                        class="btn btn-danger btn-sm text-white float-right">Delete Order</a>
                    </div> 
                        <br>
                    
                <div class="card-body table-responsive p-2">    
                    
                    <table class="datatable table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Rate</th>
                                <th>Total Amount</th>
                                
                              
                            </tr>   
                        </thead>
                        <tbody>
                            @foreach($products as $order)

                            
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->product->name}}</td>
                                <td>{{$order->quantity}}</td>
                                <td>{{$order->rate}}</td>
                                <td>{{$order->amount}}</td>
                                
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
</div>

@endsection