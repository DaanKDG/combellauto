@extends('layouts.app')

@section('content')

<div class="jumbotron">
	<div class="container">
		<h1 class="display-4">DETAIL {{ strtoupper($name) }} </h1>
	</div>
</div>

<div class="container">

	<table class="table">
	  	<tbody>
		    <tr>
	      		<th scope="row">Domain Name</th>
	      		<td>{{ $data['domain_name'] }}</td>
	    	</tr>

		    <tr>
	      		<th scope="row">Servicepack ID</th>
	      		<td>{{ $data['servicepack_id'] }}</td>
	    	</tr>

		    <tr>
	      		<th scope="row">Max size</th>
	      		<td>{{ $data['max_size'] }}</td>
	    	</tr>

		    <tr>
	      		<th scope="row">Actual size</th>
	      		<td>{{ $data['actual_size'] }}</td>
	    	</tr>

		    <tr>
	      		<th scope="row">IP</th>
	      		<td>{{ $data['ip'] }}</td>
	    	</tr>
	  	</tbody>
	</table>

</div>

@endsection