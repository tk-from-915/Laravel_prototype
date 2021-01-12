@extends('web.web_common')
@section('title', 'Page')

@section('contents')
<h5 id="page_title">{{ $page->title }}</h5>
<div id="page_content">
	{{ $page->content }}
</div>
@endsection