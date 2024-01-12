@extends('layouts.admin')

@section('content')

@php
    use App\Enums\DeliveryStatus;
@endphp

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
                    <div class="row float-left">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div>
                            Status: 
                            {{ \App\Enums\DeliveryStatus::getDescription((int) $orders->delivery_status) }}
                        </div>    
                    </div>   
                    <br>   <br>
                    <div class="row ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div>
                            Delivery Address: 
                            {{$address->street}},{{$address->city}},{{$address->state}},{{$address->country}}
                        </div>    
                    </div> 
                    <br>
                    @if($address->contact_name)
                    <div class="row ">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div>
                            Contact Name.: 
                            {{$address->contact_name}}
                        </div>    
                    </div> 
                    @else
                    @endif
                    <br>
                    @if($address->contact_no)
                        <div class="row ">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div>
                                Contact No.: 
                                {{$address->contact_no}}
                            </div>    
                        </div> 
                    @else
                    @endif
                    <br>
                   
                        <div class="row ">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div>
                               Delivery Type: 
                                @if($address->type ==1)
                                 Cash on delivery
                                @else
                                 Paypal
                                @endif
                            </div>    
                        </div> 
                    

                    <div class="row float-right">
                        @if((int) $orders->delivery_status === \App\Enums\DeliveryStatus::Delivered)
                            <a 
                            href="{{url('admin/order/'.$orders->id.'/cancel')}}"  method="get"
                            class="btn btn-danger btn-sm text-white float-right">Cancel Order</a>
                            &nbsp;&nbsp;&nbsp;
                            <a 
                            href="{{url('admin/order/'.$orders->id.'/delete')}}"  method="get"
                            class="btn btn-danger btn-sm text-white float-right">Delete Order</a>

                        @elseif((int) $orders->delivery_status === \App\Enums\DeliveryStatus::Cancelled)
                            <form action="{{ url('admin/order/'.$orders->id.'/deliver') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm text-white float-right">Delivered</button>
                            </form>
                            &nbsp;&nbsp;&nbsp;
                            <a 
                            href="{{url('admin/order/'.$orders->id.'/delete')}}"  method="get"
                            class="btn btn-danger btn-sm text-white float-right">Delete Order</a>

                        @else
                            <form action="{{ url('admin/order/'.$orders->id.'/deliver') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm text-white float-right">Delivered</button>
                            </form>
                            &nbsp;&nbsp;&nbsp;
                            <a 
                            href="{{url('admin/order/'.$orders->id.'/cancel')}}"  method="get"
                            class="btn btn-danger btn-sm text-white float-right">Cancel Order</a>
                            &nbsp;&nbsp;&nbsp;
                            <a 
                            href="{{url('admin/order/'.$orders->id.'/delete')}}"  method="get"
                            class="btn btn-danger btn-sm text-white float-right">Delete Order</a>
                        @endif
                    </div> 
                        <br>
                    
                <div class="card-body table-responsive p-2">    
                    
                <table class="datatable table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            
                            <th>Quantity</th>
                            <th>Size</th>
                            <th>Rate</th>
                         
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grandTotal = 0; // Initialize the grand total
                        @endphp

                        @foreach($products as $order)
                            @php
                                $totalAmount = $order->quantity * $order->rate;
                                $grandTotal += $totalAmount; // Add the total amount to the grand total
                            @endphp

                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->product->name}}</td>
                                <td>{{$order->quantity}}</td>
                                <td>
                                    @if ($order->sizes)
                                        {{ $order->sizes->size }}
                                    @else
                                        No Size
                                    @endif
                                </td>
                                <td>{{$order->rate}}</td>
                                <td>{{$totalAmount}}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="5" align="right"><strong>Grand Total:</strong></td>
                            <td>{{$grandTotal}}</td>
                        </tr>
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