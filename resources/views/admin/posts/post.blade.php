@extends('admin.admin_common')

@section('admin_page_title') 
    {{ $post->post_title }}
@endsection

@section('content')
    <div class="form_block">
        <div id ="thumnail_image">        
        @if ( $post->file_path )
            <img src = "/{{ $post->file_path }}">
        @else
            <img class="post_image" src="/images/noimages.png" alt="no images">
        @endif
        </div>
    </div>
    <div class="form_block post_content">{{$post->post_content}}</div>
    <div class="form_block">
        <button id="right" class="green_button">
        @switch(true)
            @case(strpos(request()->path(),'admin/menus')!==false)
                <a href="{{ route('menu_article', ['posts_id' => $post->id]) }}" target=”_blank” class="whitelink">
                @break
            @case(strpos(request()->path(),'admin/news')!==false)
                <a href="{{ route('news_article', ['posts_id' => $post->id]) }}" target=”_blank” class="whitelink">
                @break
            @case(strpos(request()->path(),'admin/blogs')!==false)
                <a href="{{ route('blog_article', ['posts_id' => $post->id]) }}" target=”_blank” class="whitelink">
                @break
        @endswitch
        {{ __('作成した記事を見る') }}
        </a></button>
        <button id="left" class="green_button">
        @switch(true)
            @case(strpos(request()->path(),'admin/menus')!==false)
                <a href="{{ route('menus.edit', ['menu' => $post->id]) }}" class="whitelink">
                @break
            @case(strpos(request()->path(),'admin/news')!==false)
                <a href="{{ route('news.edit', ['news' => $post->id]) }}" class="whitelink">
                @break
            @case(strpos(request()->path(),'admin/blogs')!==false)
                <a href="{{ route('blogs.edit', ['blog' => $post->id]) }}" class="whitelink">
                @break
        @endswitch
        {{ __('再度編集する') }}
        </a></button>
    </div>
@endsection