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
        

        <div class="col-md-12 ">

            @if(session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
            @endif

            <div class="card-header">
                <h4>Category
                    <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right">Add Category</a>

                </h4>
            </div>
            <div class="card-body">

            </div>
            <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <div class="card-body table-responsive p-2">    
            
                                <table class="datatable table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Picture</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)

                                        
                                        <tr>
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->status == '1'? 'Active' :'Inactive'}}</td>
                                            <td>
                                                @if($category->image)
                                                <img 
                                                src="{{asset('/uploads/category/'.$category->image)}}"
                                                 style="width: 80px; height:80px;" alt="No image"/>
                                                 @else
                                                 <h5>No Image</h5>
                                                @endif 
                                            </td>
                                            <td>
                                                <a href="{{url('admin/category/'.$category->id.'/edit')}}" class="btn btn-success btn-sm text-white">Edit</a>
                                            &nbsp;
                                                <a 
                                                href="{{url('admin/category/'.$category->id.'/delete')}}" 
                                                    class="btn btn-danger btn-sm text-white">Delete</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>    

                            </div>
                            <br>
                            <div class="pagination" style="float: right;">{{$categories->links()}}</div>

                          
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>

        </div>
    </div>   

@endsection