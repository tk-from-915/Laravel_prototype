@extends('base_common')

@section('wrapper')
<div id="wrapper">
	<div id="management_screen_sidebar">
		<ul id="management_screen_items">
			<li id="sidebar_li_home"><a id="sidebar_a_home" href="{{ url('admin') }}" class="whitelink">Home</li>
			<li id="sidebar_li_users"><a id="sidebar_a_users" href="{{ route('users.index') }}" class="whitelink">User</a></li>
			<li id="sidebar_li_menus"><a id="sidebar_a_menus" href="{{ url('admin/menus') }}" class="whitelink">Menu</a></li>
			<li id="sidebar_li_news"><a id="sidebar_a_news" href="{{ url('admin/news') }}" class="whitelink">News</a></li>
			<li id="sidebar_li_blogs"><a id="sidebar_a_blogs" href="{{ url('admin/blogs') }}" class="whitelink">Blog</a></li>
			<li id="sidebar_li_pages"><a id="sidebar_a_pages" href="{{ url('admin/pages') }}" class="whitelink">Page</a></li>
			<li id="sidebar_li_contacts"><a id="sidebar_a_contacts"href="{{ url('admin/contacts') }}" class="whitelink">Contact&Requruit</a></li>
		</ul>
	</div>
	<div id="right_block">
		<div id ="management_screen_header">
			<div id ="goto_web"><a href="{{ url('/') }}" target="_blank" class="whitelink">to Web ↑</a></div>
			<div id ="user_info">
				<a id="management_screen_header_dropdown" class="whitelink" href="#" data-toggle="dropdown">
					{{ Auth::user()->name }}
				</a>
				<div class="triangle"></div>
				<div class="dropdown_menu">
					<a href="{{ route('logout') }}"
						onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
						{{ __('Logout') }}
					</a>

					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</div>
			</div>
		</div>
		<div id="edit_block">
			<div id="content">
				<div class="admin_page_title">@yield('admin_page_title')</div>
				@yield('content')
			</div>
		</div>
	</div>
</div>
@endsection