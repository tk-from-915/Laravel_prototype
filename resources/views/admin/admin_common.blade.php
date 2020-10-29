@extends('base_common')

@section('wrapper')
<div id="wrapper">
	<div id="management_screen_sidebar">
		<ul id="management_screen_items">
			<li class="this_page">Home</li>
			<li><a href="admin/users.html" class="whitelink">User</a></li>
			<li><a href="admin/menus.html" class="whitelink">Menu</a></li>
			<li><a href="admin/news.html" class="whitelink">News</a></li>
			<li><a href="admin/blogs.html" class="whitelink">Blog</a></li>
			<li><a href="admin/pages.html" class="whitelink">Page</a></li>
			<li><a href="admin/contact.html" class="whitelink">Contact&Requruit</a></li>
		</ul>
	</div>
	<div id="right_block">
		<div id ="management_screen_header">
			<div id ="goto_web"><a href="../index.html" target="_blank" class="whitelink">to Web ↗️</a></div>
			<div id ="user_info">
				User ▼
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