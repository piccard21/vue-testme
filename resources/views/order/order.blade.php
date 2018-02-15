@extends('layouts.app')

@section('content')

	<ix-jumbotron header="{{ __('Order confirmation')  }}" subheader=""></ix-jumbotron>
	<div class="container">

		<el-row>
			<el-col :span="20" :offset="2">
				<div class="grid-content">
					<ix-steps :activestep="3" finished="process"></ix-steps>
				</div>
			</el-col>
		</el-row>

		<el-row>
			<el-col :span="24">
				<div class="grid-content">
					<ix-order-process></ix-order-process>
				</div>
			</el-col>
		</el-row>

	</div>

@endsection


