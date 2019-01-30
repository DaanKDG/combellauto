@extends('layouts.app')

@section('content')

<div class="jumbotron">
	<div class="container">
		<h1 class="display-4">MAIL TEST</h1>
	</div>
</div>

<div class="container">

	<form action="" method="POST">
		@csrf
		<button type="submit">SUMBIT</button>
	</form>

</div>


@endsection