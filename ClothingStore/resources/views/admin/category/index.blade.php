@extends('layouts.admin')

@section('content')

    <div class="row">
        <div>
            @if(session('message'))
                <h2 class="alert alert-success">{{session('message')}}</h2>    
            @endif
        </div>

        <div class="col-md-12 ">
            <div class="card-header">
                <h4>Category
                    <a href="{{route('category.create')}}" class="btn btn-primary btn-sm float-right">Add Category</a>

                </h4>
            </div>
            <div class="card-body">


            </div>

        </div>
    </div>   

@endsection