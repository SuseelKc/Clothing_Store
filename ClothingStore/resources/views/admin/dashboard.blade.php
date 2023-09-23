@extends('layouts.admin')

@section('content')
    
<div>
    @if(session('message'))
        <h2 class="alert alert-success">{{session('message')}}</h2>    
    @endif
</div>
    {{-- <h1>Welcome Admin!</h1> --}}
@endsection
   
