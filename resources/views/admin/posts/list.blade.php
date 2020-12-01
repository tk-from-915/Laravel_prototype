@extends('admin.admin_common')

@section('admin_page_title')
    {{ $page_title }}一覧
@endsection

@section('content')
<div id="right_module">
    <div id="delete_item"><img src="/images/delete_red.jpeg"></div>
    <div id="create_item">
        @if (request()->path() == 'admin/menus')
            <a href="{{ route('menus.create') }}" class="whitelink">
        @elseif (request()->path() == 'admin/news')
            <a href="{{ route('news.create') }}" class="whitelink">
        @elseif (request()->path() == 'admin/blogs')
            <a href="{{ route('blogs.create') }}" class="whitelink">
        @endif
            ＋ new
        </a>
    </div>
</div>

<table id="admin_table">
    <tr>
        <th><img src="/images/delete_green.png"></th>
        <th>タイトル</th>
        <th>作成者</th>
        @if (request()->path() == 'admin/menus')
        <th>コメント数</th>
        @endif
        <th>投稿日時</th>
    </tr>
    @foreach($posts as $post)
    <tr>
        <td><input type="checkbox" name="delete_check" value="{{ $post->id }}"></td>
        <td>
        @switch(request()->path())
            @case('admin/menus')
                <a href="{{ route('menus.edit', ['menu' => $post->id]) }}">
                @break
            @case('admin/news')
                <a href="{{ route('news.edit', ['news' => $post->id]) }}">
                @break
            @case('admin/blogs')
                <a href="{{ route('blogs.edit', ['blog' => $post->id]) }}">
                @break
        @endswitch
            {{ $post->post_title }}
            </a>
        </td>
        <td>{{ $post->name }}</td>
        @if (request()->path() == 'admin/menus')
        <td>1</td>
        @endif
        <td>{{ $post->updated_at }}</td>
    </tr>
    @endforeach
</table>
@endsection