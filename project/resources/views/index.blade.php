@extends('layouts.app')

@section('content')

<div class="jumbotron">
	<div class="container">
		<h1 class="display-4">INDEX</h1>
	</div>
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