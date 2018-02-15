@extends('layouts.app')

@section('content')
		<ix-jumbotron header="{{ __('Domain search')  }}" subheader="... doch ienen subheader?"></ix-jumbotron>

		<div class="container">

			{{--steps--}}
			<div class="row">
				<div class="col-md-10 offset-md-1">
					<ix-steps :activestep="1" finished="finish"></ix-steps>
				</div>
			</div>
			<div class="row" style="margin-bottom: 1rem;">
				{{--tld-filter--}}
				<div class="col-md-6">
					<ix-tld-list></ix-tld-list>
				</div>
				{{--search--}}
				<div class="col-md-6">
					<ix-search></ix-search>
				</div>
			</div>

			{{--domain-list-table--}}
			<div class="row">
				<div class="col">
					<ix-domain-list></ix-domain-list>
				</div>
			</div>

			{{--next-btn--}}
			<div class="row">
				<div class="col">
					<ix-next-btn location="{{route('order.index')}}" label="{{ __('Next') }}"></ix-next-btn>
				</div>
			</div>
		</div>

@endsection