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
                                <td>
                                    @if((int)$order->delivery_status === \App\Enums\DeliveryStatus::Delivered)
                                        Delivered
                                    @elseif((int)$order->delivery_status === \App\Enums\DeliveryStatus::Cancelled)
                                        Cancelled
                                    @elseif((int)$order->delivery_status === \App\Enums\DeliveryStatus::Processing)
                                        Processing
                                    @else
                                        
                                    @endif
                                </td>
                                <td>{{ \App\Enums\PaymentType::getDescription((int)$order->payment_type) }}</td>
                                
                                <td>
                                    
                                    @if((int)$order->delivery_status === \App\Enums\DeliveryStatus::Delivered)
                                         <a href="{{url('admin/order/'.$order->id.'/view')}}" class="btn btn-primary btn-sm text-white" >Details</a>
                                         <a 
                                        href="{{url('admin/order/'.$order->id.'/cancel')}}"
                                        class="btn btn-danger btn-sm text-white open-cancel-modal"
                                        data-toggle="modal" 
                                        data-target="#cancelModal"
                                        data-cancel-id="{{$order->id}}"
                                        >Cancel Order</a>
                                        <a 
                                        href="{{url('admin/order/'.$order->id.'/cancel')}}"
                                        class="btn btn-danger btn-sm text-white open-delete-modal"
                                        data-toggle="modal" 
                                        data-target="#deleteModal"
                                        data-delete-id="{{$order->id}}"
                                        >Delete Order</a>

                                    @elseif((int)$order->delivery_status === \App\Enums\DeliveryStatus::Cancelled)
                                        <a href="{{url('admin/order/'.$order->id.'/view')}}" class="btn btn-primary btn-sm text-white" >Details</a>
                                        <a 
                                        href="{{url('admin/order/'.$order->id.'/deliver')}}" 
                                        class="btn btn-success btn-sm text-white open-deliver-modal"
                                        data-toggle="modal" 
                                        data-target="#deliverModal"
                                        data-order-id="{{$order->id}}"
                                        >Delivered</a>
                                        <a 
                                        href="{{url('admin/order/'.$order->id.'/cancel')}}"
                                        class="btn btn-danger btn-sm text-white open-delete-modal"
                                        data-toggle="modal" 
                                        data-target="#deleteModal"
                                        data-delete-id="{{$order->id}}"
                                        >Delete Order</a>

                                    @else
                                        <a href="{{url('admin/order/'.$order->id.'/view')}}" class="btn btn-primary btn-sm text-white" >Details</a>
                                        <a 
                                        href="{{url('admin/order/'.$order->id.'/deliver')}}" 
                                        class="btn btn-success btn-sm text-white open-deliver-modal"
                                        data-toggle="modal" 
                                        data-target="#deliverModal"
                                        data-order-id="{{$order->id}}"
                                        >Delivered</a>
                                        <a 
                                        href="{{url('admin/order/'.$order->id.'/cancel')}}"
                                        class="btn btn-danger btn-sm text-white open-cancel-modal"
                                        data-toggle="modal" 
                                        data-target="#cancelModal"
                                        data-cancel-id="{{$order->id}}"
                                        >Cancel Order</a>
                                        <a 
                                        href="{{url('admin/order/'.$order->id.'/cancel')}}"
                                        class="btn btn-danger btn-sm text-white open-delete-modal"
                                        data-toggle="modal" 
                                        data-target="#deleteModal"
                                        data-delete-id="{{$order->id}}"
                                        >Delete Order</a>
                                    @endif
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
</div>
{{-- All modal --}}

<!-- Delivered Modal -->
<div class="modal fade" id="deliverModal" tabindex="-1" role="dialog" aria-labelledby="deliverModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="deliverModalLabel">Order Delivered</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="#" method="POST" id="deliverForm"> <!-- Give your form an ID -->
            @csrf    
                <div class="modal-body">
                    <h6>Order No. <span id="orderNumber"></span> delivered?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Delivered</button>
                </div>
            </form>           
        </div>
    </div>
</div>

{{-- cancel modal --}}
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="cancelModalLabel">Cancel Order</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="#" method="GET" id="cancelForm"> <!-- Give your form an ID -->
            @csrf    
                <div class="modal-body">
                    <h6> Cancel Id No. <span id="cancelNumber"></span>?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </div>
            </form>           
        </div>
    </div>
</div>

{{-- delete modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Delete Order</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="#" method="GET" id="deleteForm"> <!-- Give your form an ID -->
            @csrf    
                <div class="modal-body">
                    <h6> Delete Order No. <span id="deleteNumber"></span>?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>           
        </div>
    </div>
</div>





{{-- Delivered model js --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".open-deliver-modal").on("click", function (event) {
            event.preventDefault();
            var orderId = $(this).data("order-id");
            $("#orderNumber").text(orderId); // Set order ID in the modal
            $("#deliverForm").attr("action", "/admin/order/" + orderId + "/deliver"); // Set form action
            $("#deliverModal").modal("show");
        });
    });
</script>
{{-- delete script --}}
<script>
    $(document).ready(function () {
        $(".open-cancel-modal").on("click", function (event) {
            event.preventDefault();
            var orderId = $(this).data("cancel-id");
            $("#cancelNumber").text(orderId); // Set order ID in the modal
            $("#cancelForm").attr("action", "/admin/order/" + orderId + "/cancel"); // Set form action
            $("#cancelModal").modal("show");
        });
    });
</script>
{{-- delete script --}}
<script>
    $(document).ready(function () {
        $(".open-delete-modal").on("click", function (event) {
            event.preventDefault();
            var orderId = $(this).data("delete-id");
            $("#deleteNumber").text(orderId); // Set order ID in the modal
            $("#deleteForm").attr("action", "/admin/order/" + orderId + "/delete"); // Set form action
            $("#deleteModal").modal("show");
        });
    });
</script>

@endsection