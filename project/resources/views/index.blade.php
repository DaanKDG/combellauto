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
	    		<th scope="col">Servicepack ID</th>
	      		<th scope="col">Domain Name</th>
	      		<th scope="col">Size</th>
	      		<th scope="col">Inactive</th>
	      		<th scope="col">Delete</th>
	    	</tr>
	  	</thead>
	  	<tbody>

	  		@foreach ($accounts as $account)

		    <tr>
	      		<th scope="row">{{ $account["servicepack_id"] }}</th>
	      		<td>{{ $account["domain_name"] }}</td>
	    	</tr>

		    @endforeach

	  	</tbody>
	</table>

</div>

@endsection