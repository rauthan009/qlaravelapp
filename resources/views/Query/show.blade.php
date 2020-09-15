@extends('layouts.app')

@section('content')
    
<div class="container">
    <a class="btn btn-primary" href="{{ route('query.index') }}">Back to query dashboard</a> 
    <div class="container">
        <p>    
            <h3>{{$query->query}}</h3>
            <small> Raised on {{$query->created_at}} by {{$query->user->name}}</small>
            <div>
                @if( !empty($query->solution))
                    <hr>
                    <p>{{$query->solution}}</p>  
                @else
                    <hr>
                    <p> No Solution yet </p>     
                    @if(Auth::user()->Role == 'admin')
                        <a class="btn btn-primary" href="{{ route('query.edit',$query->id) }}">Answer</a>               
                    @endif    
                @endif
                
                @if (Auth::user()->id == $query->user_id)
                    <form action="{{route('query.destroy',$query->id)}}" method="post" class="btn pull-right">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>
                @endif                    
            </div>
        </p> 
    </div>   
</div>

@endsection