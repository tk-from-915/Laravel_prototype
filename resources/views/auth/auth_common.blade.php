@extends('base_common')

@section('wrapper')
<div id="wrapper">
	<div id ="admin_header">
		<div id ="admin_header_left">Little Healing Green  @yield('auth_page_title')</div>
		<div id ="admin_header_right"><a href="register.html" class="whitelink">@yield('auth_anothor_link')</a></div>
	</div>
	<div id="login_form">
		<div class="login_title">@yield('auth_login_title')</div>
		<div id="login_form_area">
            @yield('contents')
		</div>
	</div>
</div>
	
@endsection