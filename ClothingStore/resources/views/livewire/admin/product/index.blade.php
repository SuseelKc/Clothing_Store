<div>
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
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Discounted Price</th>
                                        <th>Color</th>
                                        <th>Picture</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>   
                                </thead>
                                <tbody>
                                    @foreach($products as $product)

                                    
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td>{{$product->name}}</td>
                                        <td>{{$product->description}}</td>
                                        <td>{{$product->quantity}}</td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->discounted_price}}</td>
                                        <td>
                                            @if($product->color)
                                            {{$product->color}}
                                            @else
                                            <h6>Color Unavailable</h6>
                                            @endif
                                        </td>
                                        <td>
                                            @if($product->productImage->isNotEmpty())
                                                <img src="{{ asset($product->productImage[0]->image) }}"
                                                    style="width: 80px; height: 80px;" alt="No image"/>
                                            @else
                                                <h5>No Image</h5>
                                            @endif
                                        </td>
                                        <td>{{$product->category->name}}</td>
                                        <td>
                                            <a href="{{url('admin/product/'.$product->id.'/edit')}}" class="btn btn-success text-white">Edit</a>
                                            
                                            <!-- Button trigger modal -->
                                            <a  class="btn btn-danger text-white" 
                                            wire:click="deleteProduct({{$product->id}})"
                                            data-toggle="modal" data-target="#deleteModal">
                                                Delete
                                            </a>

                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                    

                                </tbody>
                            


                            </table>

                        
                        </div>
                        <br>
                        <div class="pagination float-right"
                >{{$products->links()}}</div>
                    
        

                </div>

                
            </div>

        </div>

    
    <!-- Modal -->
    <div  wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                </div>
                <form wire:submit.prevent="destroyProduct">

                            <div class="modal-body">
                            <h6>Are you Sure to delete Id :
                                @if(isset($product))
                                 {{{$product->id}}}
                                @endif
                                
                            </h6>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                </form>            
            </div>
        </div>
    </div>



</div>