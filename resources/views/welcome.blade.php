@extends('layouts.app')

@section('content')
	<ix-jumbotron header="Domain-Promo" subheader="... alles Weitere wird geklärt"></ix-jumbotron>


	<div class="container">
		<div class="list-group">
			<a href="/customer/123456789" class="list-group-item list-group-item-action">
				/customer/123456789
			</a>
			<a href="/customer/456789123" class="list-group-item list-group-item-action">/customer/456789123</a>
		</div>
	</div>
@endsection