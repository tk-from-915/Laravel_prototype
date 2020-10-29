@extends('base_common')

@section('wrapper')
<div id="wrapper">
	<div id="management_screen_sidebar">
		<ul id="management_screen_items">
			<li id="sidebar_li_home"><a id="sidebar_a_home" href="admin.html" class="whitelink">Home</li>
			<li id="sidebar_li_users"><a id="sidebar_a_users" href="admin/users.html" class="whitelink">User</a></li>
			<li id="sidebar_li_menus"><a id="sidebar_a_menus" href="admin/menus.html" class="whitelink">Menu</a></li>
			<li id="sidebar_li_news"><a id="sidebar_a_news" href="admin/news.html" class="whitelink">News</a></li>
			<li id="sidebar_li_blogs"><a id="sidebar_a_blogs" href="admin/blogs.html" class="whitelink">Blog</a></li>
			<li id="sidebar_li_pages"><a id="sidebar_a_pages" href="admin/pages.html" class="whitelink">Page</a></li>
			<li id="sidebar_li_contacts"><a id="sidebar_a_contacts"href="admin/contact.html" class="whitelink">Contact&Requruit</a></li>
		</ul>
	</div>
	<div id="right_block">
		<div id ="management_screen_header">
			<div id ="goto_web"><a href="../index.html" target="_blank" class="whitelink">to Web ↗️</a></div>
			<div id ="user_info">
				<li class="nav-item dropdown">
					<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						{{ Auth::user()->name }} <span class="caret"></span>
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ route('logout') }}"
							onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</li>
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