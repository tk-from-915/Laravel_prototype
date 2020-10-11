@extends('base_common')

@section('title', 'anothor Page')

@section('wrapper')
	@component('layouts.humbarger_menu')
	@endcomponent
	<div id ="backgroud">

	@yield('contents')

	</div>
	@component('layouts.footer')
	@endcomponent
@endsection