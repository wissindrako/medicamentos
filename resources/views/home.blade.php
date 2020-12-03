@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
	<div class="container spark-screen">
		<div class="row">
			{{-- <div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">Bienvenid@</div>

					<div class="panel-body">
						{{ trans('adminlte_lang::message.logged') }}
						{{$personas}}
					</div>
				</div>
			</div> --}}

			<div style="text-align:center">

				<h1 class=""><b>SISTEMA EXPERTO </b></h1>
				{{-- <h3><b>Administración </b></h3> --}}
				<img src="{{asset('img/logo-univalle.jpeg')}}" style="width:550x;height:450px;" class="centered"/>
			</div>
		</div>
	</div>
@endsection
