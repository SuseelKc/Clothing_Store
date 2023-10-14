@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <div class="card-header">
                <h4> Edit User / {{$user->name}}
                    <a href="{{url('/admin/userview')}}" class="btn btn-primary btn-sm float-right">Back</a>

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
                action="{{url('admin/user/'.$user->id.'/update')}}" 
                     method="POST" enctype="multipart/form-data"> 
                    @csrf
                   <div class="row">
                        <div class="col-md mb-3">
                            <label>Name
                            </label>
                            <input type="text" name="name" class="form-control" value="{{$user->name}}"/>
                            @error('name') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="col-md mb-3">
                            <label>Email
                            </label>
                            <input type="email" name="email" class="form-control" value="{{$user->email}}"/>
                            @error('email') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                   </div>    
                   <div class="row">
                        <div class="col-md mb-3">
                            <label>Address
                            </label>
                            <input type="text" name="address" class="form-control" value="{{$user->address}}"/>
                            @error('address') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="col-md mb-3">
                            <label>Contact No.
                            </label>
                            <input type="number" name="contact" class="form-control" value="{{$user->contact}}"/>
                            @error('contact') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                   </div> 

                  

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary text-white float-end">Update</button>    
                       </div>

                    </form>

            </div>

        </div>
    </div>   

@endsection