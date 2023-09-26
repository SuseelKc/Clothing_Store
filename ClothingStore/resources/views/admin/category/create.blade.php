@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <div class="card-header">
                <h4> Add Category
                    <a href="{{route('category')}}" class="btn btn-primary btn-sm float-right">Back</a>

                </h4>
            </div>
            <style>
                .card-body {
                    border: 1px solid #ccc; /* Add a border around the div */
                    padding: 20px; /* Add space inside the div */
                    border-radius: 5px; /* Add rounded corners for a box-like appearance */
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a shadow to give it depth */
                }
            </style>
            <div class="card-body">
                    <form action="{{route('category.store')}}"  method="POST" enctype="multipart/form-data"> 
                    @csrf
                        <div class="row">
                        <div class="col-md mb-3">
                            <label>Name
                            </label>
                            <input type="text" name="name" class="form-control"/>
                            @error('name') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="col-md mb-3">
                            <label>Slug
                            </label>
                            <input type="text" name="slug" class="form-control"/>
                            @error('slug') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md mb-3" >
                            <label>Description
                            </label>
                            <textarea style="height:90px; width:543px" name="description" class="form-control"></textarea><br>
                            @error('slug') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control"/>     
                       </div>
                    </div>    

                        <div class="col-md-6 mb-3">
                            <label>Status(Active/Inactive): </label>
                            <input type="checkbox" name="status" checked/>   <br><br>
                            <label> <i>Note: Deselect to make status Inactive</i> </label> 
                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary text-white float-end">Save</button>    
                       </div>

                    </form>

            </div>

        </div>
    </div>   

@endsection