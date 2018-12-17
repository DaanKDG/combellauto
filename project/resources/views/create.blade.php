@extends('layouts.app')

@section('content')
<div class="jumbotron">
    <h2 class="text-center">CREATE ACCOUNT</h2>
</div>
<div class="container">
    {{-- <input type="text" class="form-control"> --}}
    <a href="{{ route('api.create') }}" class="btn btn-outline-dark">Create new account</a>
</div>
@endsection