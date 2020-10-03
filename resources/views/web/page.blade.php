@extends('base_common')

@section('title', 'anothor Page')

@section('content')
	@component('layouts.humbarger_menu')
	@endcomponent
	<div id ="backgroud">

		<h5 id="page_title">会社情報</h5>
		<div id="content">
			<p>ここに本文が入ります。ここに本文が入ります。
				
			</p>
		</div>
	</div>
	@component('layouts.footer')
	@endcomponent
@endsection