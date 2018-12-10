@extends('layouts.app')

@section('content')

<div class="jumbotron text-center">
    <h1 style='font-weight:bold;'>INDEX</h1>
</div>

<div class="container">

    @foreach ($accounts as $account)

    <div class="account">
    	<h3>Account: {{ $account["identifier"] }} </h3>
    	<p>ID = {{ $account["id"] }}</p>
    </div>

    @endforeach

</div>

@endsection