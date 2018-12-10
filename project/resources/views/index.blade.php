@extends('layouts.app')

@section('content')

<div class="jumbotron">
	<div class="container">
		<h1 class="display-4">INDEX</h1>
	</div>
</div>

<div class="container">

	<table class="table">
		<thead>
	    	<tr>
	    		<th scope="col">ID</th>
	      		<th scope="col">Identifier</th>
	    	</tr>
	  	</thead>
	  	<tbody>

	  		@foreach ($accounts as $account)

		    <tr>
	      		<th scope="row">{{ $account["id"] }}</th>
	      		<td>{{ $account["identifier"] }}</td>
	    	</tr>

		    @endforeach

	  	</tbody>
	</table>

</div>

@endsection