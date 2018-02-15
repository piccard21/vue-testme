@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="d-flex align-items-center justify-content-center flex-column">

			@yield('http-error')

			<a href="{{ url()->previous() }}" class="btn btn-info">back</a>
		</div>
	</div>


@endsection