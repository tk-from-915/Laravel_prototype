@extends('admin.admin_common')

@section('admin_page_title')
    {{ $page_title }}一覧
@endsection

@section('content')
<div id="right_module">
    <div id="delete_item"><img src="/images/delete_red.jpeg"></div>
    <div id="create_item">
        @if ($posts[0]->post_type == 0)
            <a href="{{ route('menus.create') }}" class="whitelink">
        @elseif ($posts[0]->post_type == 1)
            <a href="{{ route('news.create') }}" class="whitelink">
        @elseif ($posts[0]->post_type == 2)
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
        @if ($posts[0]->post_type == 0)
        <th>コメント数</th>
        @endif
        <th>投稿日時</th>
    </tr>
    @foreach($posts as $post)
    <tr>
        <td><input type="checkbox" name="delete_check" value="{{ $post->id }}"></td>
        <td>
            {{ $post->post_title }}
            </a>
        </td>
        @foreach($users as $user)
        <td>{{{</td>
        @endforeach
        @if ($posts[0]->post_type == 0)
        <td></td>
        @endif
        <td>{{ $post->updated_at }}</td>
    </tr>
    @endforeach
</table>
@endsection