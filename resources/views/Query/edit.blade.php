@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('query.update',$query->id) }}"  method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <h3>{{$query->query}}</h3>          
            <div class="md-form">
                <label for="solution">Enter your solution:</label>
                <textarea id="solution" class="md-textarea form-control"  name="solution" rows="3"></textarea>            
            </div>
          
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>

@endsection
