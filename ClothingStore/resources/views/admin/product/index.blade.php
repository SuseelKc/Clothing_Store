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

    <div class="col-md-12">
        @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif

        <div class="card">
        <div class="card-header">
            <h3> Product
                <a href="{{route('product.create')}}" class="btn btn-primary btn-sm text-white float-right">Add Product</a>
            </h3>
        </div>
            <div class="card-body">
            <div class="card-body table-responsive p-2">    

                <table class="datatable table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Color</th>
                            <th>Picture</th>
                            <th>Action</th>
                        </tr>   
                    </thead>
                    <tbody>
                        @foreach($products as $product)

                        
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->price}}</td>
                            <td>
                                @if($product->color)
                                {{$product->color}}
                                @else
                                <h6>Color Unavailable</h6>
                                @endif

                            </td>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('/uploads/products/'.$product->image) }}"
                                         style="width: 80px; height: 80px;" alt="No image"/>
                                @else
                                    <h5>No Image</h5>
                                @endif
                            </td>
                            
                            <td>
                                <a href="{{url('admin/category/'.$product->id.'/edit')}}" class="btn btn-success text-white">Edit</a>
                                <a 
                                {{-- href="{{url('admin/category/'.$category->id.'/edit')}}"  --}}
                                    class="btn btn-danger text-white">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>


                </table>

            </div>
                
            </div>

        </div>
    </div>


</div> 

@endsection