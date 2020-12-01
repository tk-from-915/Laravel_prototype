@extends('web.web_common')
@section('title', 'Posts Archive')

@section('contents')

<!--メニュー一覧-->
@if ( request()->path() == 'menus')
<h5 id="page_title">{{ $posts_archive_title }}</h5>
	<div id="menu_wrapper">
        @foreach($posts as $post)
		<div class="menu_block">
			<a href="{{ route('menu_article', ['posts_id' => $post->id]) }}">
			<img src="{{ $post->file_path }}">
			<p class="menu_title">{{ $post->post_title }}</p>
			</a>
		</div>
		@endforeach
    </div>

<!--ニュースとブログ一覧-->
@else
<div id="post_archive">
    <h3 id="posts_archive_title">{{ $posts_archive_title }}</h3>
    @foreach($posts as $post)
        <a href="{{ route('news_article', ['posts_id' => $post->id]) }}">
            <div class="post_block">
                <div class="post_thumnail"><img src = "{{ $post->file_path }}"></div>
                <div class="post_title">{{ $post->post_title }}</div>
                <div class="post_created_at">{{ $post->created_at }}</div>
                <div class="post_author">Author：{{ $post->name }}</div>
            </div>
        </a>
    @endforeach
</div>
@endif
@endsection