@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <div class="card-header">
                <h4> Add Product
                    <a href="{{route('product')}}" class="btn btn-primary btn-sm float-right">Back</a>

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
                <form action="{{route('product.store')}}"  method="POST" enctype="multipart/form-data"> 
                    @csrf
                    <div class="row">
                        <div class="col-md mb-3">
                            <label>Name
                            </label>
                            <input type="text" name="name" class="form-control"/>
                            {{-- @error('name') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror --}}
                        </div>

                        <div class="col-md mb-3">
                            <label>Quantity
                            </label>
                            <input type="number" name="quantity" class="form-control"/>
                            {{-- @error('quantity') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror --}}
                        </div>
                    </div>

                      
                    <div class="row">
                        <div class="col-md mb-3">
                            <label>Price
                            </label>
                            <input type="number" name="price" class="form-control"/>
                            {{-- @error('price') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror --}}
                        </div>

                        <div class="col-md mb-3">
                            <label>Discounted Price
                            </label>
                            <input type="number" name="dis_price" class="form-control"/>
                            {{-- @error('dis_price') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror --}}
                        </div>
                    </div>

                     
                       {{-- category --}}
                <div class="row">   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Select Category</option>
                                @foreach ($category as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            {{-- @if ($errors->has('category'))
                                <x-validation-errors>
                                    {{ $errors->first('category') }}
                                </x-validation-errors>
                            @endif --}}
                        </div>
                    </div>

                    <div class="col-md mb-3">
                        <label>Color
                        </label>
                        <input type="text" name="color" class="form-control"/>
                        {{-- @error('name') 
                        <small class="text-danger">{{$message}}</small>
                        @enderror --}}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md mb-3">
                        <label>Description
                        </label>
                        <textarea name="description" class="form-control"></textarea>
                        {{-- @error('description') 
                        <small class="text-danger">{{$message}}</small>
                        @enderror --}}
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control"/>

                           
                    </div>
                </div> 

                        <!-- <div class="col-md-6 mb-3">
                            <label>Status(Active/Inactive)</label><br/> 
                           <input type="checkbox" name="status"  />    
                        </div> -->

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary text-white float-end">Save</button>    
                       </div>

                    </form>

            </div>

        </div>
    </div>   

@endsection