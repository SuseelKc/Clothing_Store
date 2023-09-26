@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <div class="card-header">
                <h4> Edit Category / {{$category->name}}
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
                    <form 
                    action="{{url('admin/category/'.$category->id.'/update')}}"  
                    method="post" enctype="multipart/form-data"> 
                    @csrf
                        <div class="row">
                        <div class="col-md mb-3">
                            <label>Name
                            </label>
                            <input type="text" name="name" class="form-control" value="{{$category->name}}"/>
                            
                        </div>

                        <div class="col-md mb-3">
                            <label>Slug
                            </label>
                            <input type="text" name="slug" class="form-control" value="{{$category->slug}}"/>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Description
                            </label>
                            <textarea style="height:90px; width:543px" name="description" class="form-control">{{$category->description}}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control"/><br>
                            <img src="{{asset('/uploads/category/'.$category->image)}}"
                             style="width: 80px; height:80px;"/>
                        </div>

                    </div>    

                        <div class="col-md-6 mb-3">
                            <label>Status(Active/Inactive)</label><br/> 
                           <input type="checkbox" name="status"  {{$category->status=='1'? 'checked': ''}} />    
                        </div>

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary text-white float-end">Update</button>    
                       </div>

                    </form>

            </div>

        </div>
    </div>   

@endsection