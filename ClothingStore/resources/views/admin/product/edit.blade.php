@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-12 ">
            <div class="card-header">
                <h4> Edit Product / {{$product->name}}
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
                <form action="{{url('admin/product/'.$product->id.'/update')}}"  method="POST" enctype="multipart/form-data"> 
                    @csrf
                    <div class="row">
                        <div class="col-md mb-3">
                            <label>Name
                            </label>
                            <input type="text" name="name" class="form-control" value="{{$product->name}}"/>
                            @error('name') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="col-md mb-3">
                            <label>Quantity
                            </label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{$product->quantity}}"/>
                            @error('quantity') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md mb-3">
                         <div class="row" 
                         {{-- style="float: right; width: 980px;" --}}
                         >

                             {{-- <div class="col" style="float: right; margin-left: 790px;">
                                 <label for="enableInput">Enable Size:</label>&nbsp;<input type="checkbox" id="enableInput" onchange="toggleInputFields()" />
                                 
                             </div>&nbsp;&nbsp;&nbsp; --}}
                             <br><br>
                             <label style="margin-left: 500px;">Sizes(If Exists):</label><br>
                             <div class="row" style="float: right; width: 900px; margin-left: 500px;" >
                                 
                                    <label for="small">Small:</label><br>
                                    <input type="number" name="small" id="small" class="form-control" style="width: 100px;" oninput="validateTotal()"  min="1" step="1" value="{{$product->small}}" />
                                    <br>
                                    <label for="medium">Medium:</label><br>
                                    <input type="number" name="medium" id="medium" class="form-control" style="width: 100px;" oninput="validateTotal()" min="1" step="1" value="{{$product->medium}}" />
                                    <br>
                                    <label for="large">Large:</label><br>
                                    <input type="number" name="large" id="large" class="form-control"  style="width: 100px;" oninput="validateTotal()" min="1" step="1" value="{{$product->large}}" />
                                    <br>
                                    <label for="xl">XL:</label><br>
                                    <input type="number" name="xl" id="xl" class="form-control"  style="width: 100px;"oninput="validateTotal()" min="1" step="1" value="{{$product->xl}}" />
                                    <br>
                                    <label for="xxl">XXL:</label><br>
                                    <input type="number" name="xxl" id="xxl" class="form-control" style="width: 100px;" oninput="validateTotal()" min="1" step="1" value="{{$product->xxl}}" />


                                    <div id="error-message" style="color: red;"></div>
                                    <br>
                                    <br><br>
                             </div>
                          </div>
                         </div>
                 </div> 
                 <br>

                      
                    <div class="row">
                        <div class="col-md mb-3">
                            <label>Price
                            </label>
                            <input type="number" name="price" class="form-control" value="{{$product->price}}"/>
                            @error('price') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="col-md mb-3">
                            <label>Discounted Price
                            </label>
                            <input type="number" name="dis_price" class="form-control" value="{{$product->discounted_price}}"/>
                            @error('dis_price') 
                            <small class="text-danger">{{$message}}</small>
                            @enderror
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
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
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
                        <input type="text" name="color" class="form-control" value="{{$product->color}}"/>
                        @error('color') 
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md mb-3">
                        <label>Description
                        </label>
                        <textarea  style="height:90px; width:543px"
                        name="description" class="form-control">{{$product->description}}</textarea>
                        @error('description') 
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <div class="col-md mb-3">
                        <label>Tag
                        </label>
                        <input type="text" name="tags" class="form-control" value="{{$product->tags}}"/>
                        @error('tags') 
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>

                    
                </div> 
                <div class="col-md-6 mb-3">
                    <label>Image</label>
                    <input type="file" name="image[]" multiple class="form-control" /><br>
                    <div class="row">
                        @if($prodImage)
                            @foreach($prodImage as $image)
                        
                             <div class="col-md-2">
                               <img src="{{asset($image->image)}}" style="width:80px; height:80px;"
                               class="me-4 border" alt="Image"
                               >
                               <a href="{{url('admin/productimage/'.$image->id.'/delete')}}" class="d-block">Remove</a>
                            </div>   
                         
                            @endforeach
                        @else
                        <h5>No Image Added</h5>
                        @endif
                    </div>
                    {{-- <img src="{{asset('uploads/products/'.$product->image)}}"  style="height:90px; width:90px"
                    alt="No images"/>  --}}
                    @error('image') 
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>         
                

                        <!-- <div class="col-md-6 mb-3">
                            <label>Status(Active/Inactive)</label><br/> 
                           <input type="checkbox" name="status"  />    
                        </div> -->

                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary text-white float-end">Update</button>    
                       </div>

                    </form>

            </div>

        </div>
    </div>
    {{-- <script>
        function toggleInputFields() {
            var enableInputCheckbox = document.getElementById("enableInput");
            var inputFields = document.querySelectorAll("#small, #medium, #large, #xl, #xxl");
    
            for (var i = 0; i < inputFields.length; i++) {
                inputFields[i].readOnly = !enableInputCheckbox.checked;
            }
        }
    </script>   --}}
    <script>
        function validateTotal() {
            const input1 = parseInt(document.getElementById("small").value) || 0;
            const input2 = parseInt(document.getElementById("medium").value) || 0;
            const input3 = parseInt(document.getElementById("large").value) || 0;
            const input4 = parseInt(document.getElementById("xl").value) || 0;
            const input5 = parseInt(document.getElementById("xxl").value) || 0;
            const total = parseInt(document.getElementById("quantity").value) || 0;

            if (input1 + input2 + input3 + input4 + input5 !== total) {
                document.getElementById("error-message").textContent = "Error: Please verify the quantity!";
            } else {
                document.getElementById("error-message").textContent = "";
            }
        }
    </script>
    <script>
        function validateTotal() {
            // Get values from the "Small," "Medium," "Large," "XL," and "XXL" input fields
            var smallValue = parseInt(document.getElementById("small").value) || 0;
            var mediumValue = parseInt(document.getElementById("medium").value) || 0;
            var largeValue = parseInt(document.getElementById("large").value) || 0;
            var xlValue = parseInt(document.getElementById("xl").value) || 0;
            var xxlValue = parseInt(document.getElementById("xxl").value) || 0;
    
            // Calculate the total
            var total = smallValue + mediumValue + largeValue + xlValue + xxlValue;
    
            // Update the "quantity" input field with the total value
            document.getElementById("quantity").value = total;
        }
    </script>    

@endsection