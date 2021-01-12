@extends('admin.admin_common')

@section('admin_page_title') 
    {{ $page->title }}
@endsection

@section('content')
    <div class="form_block post_content">{{$page->content}}</div>
    <div class="form_block">
        <button id="right" class="green_button">
        <a href="{{ url($page->uri) }}" target=”_blank” class="whitelink">
                {{ __('作成した記事を見る') }}
            </a>
        </button>
        <button id="left" class="green_button">
            <a href="{{ route('pages.edit', ['page' => $page->id]) }}" class="whitelink">
                {{ __('再度編集する') }}
            </a>
        </button>
    </div>
@endsection