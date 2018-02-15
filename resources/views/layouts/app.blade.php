<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Domain-Promo') }}</title>

	<!-- Styles -->
	{{--favicon--}}
	<link rel="shortcut icon" href="{{ asset('img/favicon.ico')  }}">

	{{--font-awesome--}}
	{{--<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>--}}
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

	{{--all-other--}}
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<!-- main -->
<div id="app">

	<!-- flash-messages -->
	@include('layouts.message')

	<!-- errors -->
	@include('layouts.errors')

	<!-- content -->
	@yield('content')
</div>
</body>

<!-- footer -->
@include('layouts.footer')
</html>