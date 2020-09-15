@extends('layouts.app')

@section('content')
@if (Auth::user()->Role != "admin")
    <div class="container">
        <a href="{{ route('query.create') }}" type="button" class="btn btn-primary">Create a query</a>
    </div> 
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if(Auth::user()->Role == "admin")
                    <div class="card-header">{{ __('Queries') }}</div>
                @else
                    <div class="card-header">{{ __('My Queries') }}</div> 
                @endif
                <div class="card-body">                   
                   @if (!empty($queries)&&count($queries)>0)
                       @foreach ($queries as $query)
                           <a href="{{ route('query.show',$query->id) }}"><p>{{$query->query}}</p></a>
                           <small>Raised on {{$query->created_at}} by {{$query->user->name}}</small>
                           @if(!$loop->last)
                                <hr>
                            @endif
                       @endforeach
                   @else
                        @if(Auth::user()->Role == "Admin")
                            <p>No queries found</p>
                        @else
                            <p>You have not raised any queries</p>
                        @endif
                       
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
