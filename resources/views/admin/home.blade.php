@extends('admin.admin_common')

@section('admin_page_title', 'Home')

@section('content')
    <div class="admin_page_title">最新Menu情報</div>
    <div class="info_block">
    @if( count($menu_posts) != null)
        <ul>
        @foreach($menu_posts as $menu_post)
            <li>{{ $menu_post->updated_at }}   {{ $menu_post->name }}さんによって{{ $menu_post->post_title }}が更新されました。</li>
        @endforeach
        </ul>
    @else
        記事がありません
    @endif
    </div>
    <div class="admin_page_title">最新News情報</div>
    <div class="info_block">
    @if( count($news_posts) != null)
        <ul>
        @foreach($news_posts as $news_post)
            <li>{{ $news_post->updated_at }}   {{ $news_post->name }}さんによって{{ $news_post->post_title }}が更新されました。</li>
        @endforeach
        </ul>
    @else
        記事がありません
    @endif
    </div>
    <div class="admin_page_title">最新Blog情報</div>
    <div class="info_block">
    @if( count($blog_posts) != null)
        <ul>
        @foreach($blog_posts as $blog_post)
            <li>{{ $blog_post->updated_at }}   {{ $blog_post->name }}さんによって{{ $blog_post->post_title }}が更新されました。</li>
        @endforeach
        </ul>
    @else
        記事がありません
    @endif
    </div>
    <div class="admin_page_title">最新お問い合わせ情報</div>
    <div class="info_block">
        <ul>
            <li>2020/05/11    テストユーザ１さんによって モンステラ が更新されました。</li>
            <li>2020/07/18    tokiさんによって 多肉植物 が更新されました。</li>
            <li>2020/10/21    テストユーザ３さんによって テラリウム が更新されました。</li>
        </ul>
    </div>
@endsection