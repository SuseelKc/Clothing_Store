@extends('layouts.admin')

@section('content')

    <div class="row">
        

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

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
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
                                <a href="" class="btn btn-success text-white">Edit</a>
                               
                            </td>
                        </tr>
                        @endforeach
                    </tbody>


                </table>



            </div>

        </div>
    </div>   

@endsection