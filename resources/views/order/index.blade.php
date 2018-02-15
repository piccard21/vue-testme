@extends('layouts.app')

@section('content')
	<ix-jumbotron header="{{ __('Shopping cart')  }}" subheader=""></ix-jumbotron>
	<div class="container">

		<el-row>
			<el-col :span="20" :offset="2">
				<div class="grid-content">
					<ix-steps :activestep="2" finished="finish"></ix-steps>
				</div>
			</el-col>
		</el-row>

		<el-row>
			<el-col :span="24">
				<div class="grid-content">
					<ix-order-list></ix-order-list>
				</div>
			</el-col>
		</el-row>

		<br>

		<div class="text-center">
			{{--nav-btns--}}
			<ix-nav-btn location="{{ route('customer.index', ['hash'=>session('customer.hash')]) }}" label="{{ __('Back') }}"></ix-nav-btn>
			<ix-authenticate-btn></ix-authenticate-btn>

			{{--login-dialog--}}
			<ix-authentification></ix-authentification>
		</div>
	</div>
@endsection