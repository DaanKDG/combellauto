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
	    	</tr>
	  	</thead>
	  	<tbody>

	  		@foreach ($accounts as $account)

		    <tr>
	      		<th scope="row">{{ $account["servicepack_id"] }}</th>
	      		<td>
	      			<a href="{{ url('/detail/' . $account['name'] ) }}">{{ $account["domain_name"] }}</a>
	      		</td>
	    	</tr>

		    @endforeach

	  	</tbody>
	</table>

</div>

@endsection