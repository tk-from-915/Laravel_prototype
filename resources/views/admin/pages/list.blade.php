@extends('admin.admin_common')

@section('admin_page_title')
    ページ一覧
@endsection

@section('content')
<div id="right_module">
    <div id="delete_item"><img src="/images/delete_red.jpeg"></div>
    <div id="create_item">
        <a href="{{ route('pages.create') }}" class="whitelink">＋ new</a>
    </div>
</div>
@if( count($pages) != null)
    <table id="admin_table">
        <tr>
            <th><img src="/images/delete_green.png"></th>
            <th>タイトル</th>
            <th>url</th>
            <th>作成者</th>
            <th>投稿日時</th>
        </tr>
        @foreach($pages as $page)
        <tr>
            <td><input type="checkbox" name="delete_check" value="{{ $page->id }}"></td>
            <td>
            <a href="{{ route('pages.edit', ['page' => $page->id]) }}">
                {{ $page->title }}
            </a>
            </td>
            <td>{{ $page->uri }}</td>
            <td>{{ $page->name }}</td>
            <td>{{ $page->updated_at }}</td>
        </tr>
        @endforeach
    </table>
@else
    記事がありません
@endif
@endsection