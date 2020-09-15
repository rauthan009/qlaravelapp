@extends('layouts.app')

@section('content')

<div class="container">
    <form action="{{ route('query.store') }}"  method="POST">
        @csrf
        <div class="form-group">
          <label for="query">query</label>
          <input type="text" class="form-control" id="query" name="query" placeholder="Enter your query">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>

@endsection
