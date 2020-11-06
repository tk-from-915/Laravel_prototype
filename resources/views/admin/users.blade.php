@extends('admin.admin_common')

@section('admin_page_title', 'User一覧')

@section('content')
<div id="right_module">
    <div id="delete_item"><img src="/images/delete_red.jpeg"></div>
    <div id="create_item"><a href="{{ route('users.create') }}" class="whitelink">＋ new</a></div>
</div>
<table id="admin_table">
    <tr>
        <th><img src="/images/delete_green.png"></th>
        <th>ユーザ名</th>
        <th>メールアドレス</th>
        <th>権限</th>
        <th>作成日時</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td><input type="checkbox"></td>
        <td>
            @if($user->id == Auth::id())
                <a href="{{ route('users.edit', ['user' => $user->id]) }}">
            @else
                <a href="{{ route('users.show', ['user' => $user->id]) }}">   
            @endif
            {{ $user->name }}
            </a>
        </td>
        <td>{{ $user->email }}</td>
        <td>
        @if($user->authority == 0)
            {{ '投稿者' }}
        @else
            {{ '管理者' }}
        @endif
        </a></td>
        <td>{{ $user->created_at }}</td>
    </tr>
    @endforeach
</table>
@endsection