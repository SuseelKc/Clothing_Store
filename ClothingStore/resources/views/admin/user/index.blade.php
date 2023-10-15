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
                <h3> Users
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Type</th>                          
                                <th>Action</th>
                              
                            </tr>   
                        </thead>
                        <tbody>
                            
                            @foreach($user as $user)

                            @if($user->usertype==0)
                            <tr>                              
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->address}}</td>
                                @if($user->usertype==0)
                                <td>Customer</td>
                                @endif
                                <td>
                                    <a
                                    href="{{url('admin/user/'.$user->id.'/edit')}}" 
                                    class="btn btn-success btn-sm text-white">Edit</a>
                                    &nbsp;
                                        <a 
                                            class="btn btn-danger btn-sm text-white open-delete-modal"
                                            data-toggle="modal"
                                            data-target="#deleteModal"
                                            data-delete-id="{{$user->id}}"
                                            
                                            >Delete</a>
                                </td>
                            </tr>
                            @endif
                           
                            
                            @endforeach

                        </tbody>
                    


                    </table>

                
                </div>
                <br>
     


        </div>

        
    </div>

    </div>
</div>
{{-- del modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deliverModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="deliverModalLabel">Delete User</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
            </div>
            <form action="#" method="GET" id="deleteForm"> <!-- Give your form an ID -->
            @csrf    
                <div class="modal-body">
                    <h6>Delete User No. <span id="deleteNumber"></span>?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>           
        </div>
    </div>
</div>

{{--  --}}
{{-- Delivered model js --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".open-delete-modal").on("click", function (event) {
            event.preventDefault();
            var delId = $(this).data("delete-id");
            $("#deleteNumber").text(delId); // Set order ID in the modal
            $("#deleteForm").attr("action", "/admin/user/" + delId + "/delete"); // Set form action
            $("#deleteModal").modal("show");
        });
    });
</script>
{{--  --}}
@endsection