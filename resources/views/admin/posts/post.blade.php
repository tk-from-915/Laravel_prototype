@extends('admin.admin_common')

@section('admin_page_title') 
    {{ $post->post_title }}
@endsection

@section('content')
    <div class="form_block">
    @if ( $post->file_path )
        <img src = "/{{ $post->file_path }}">
    @else
        <img class="post_image" src="/images/noimages.png" alt="no images">
    @endif
    </div>
    <div class="form_block">
        {{ $post->post_content }}
    </div>
    <div class="form_block">
        <button id="center" class="green_button">
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
    </div>
@endsection