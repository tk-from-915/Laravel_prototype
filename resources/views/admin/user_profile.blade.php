@extends('admin.admin_common')

@section('admin_page_title', 'プロフィール')

@section('content')
    <div class="form_block">
        <h6>ニックネーム</h6>
        <p>{{ $user->name }}</p>
    </div>
    <div class="form_block">
        <h6>登録メールアドレス</h6>
        <p>{{ $user->email }}</p>
    </div>
    <div class="form_block">
        <h6>権限</h6>
        <p>
            @if($user->authority == 0)
                {{ '投稿者' }}
            @else
                {{ '管理者' }}
            @endif
        </p>
    </div>
    <div class="form_block">
        <h6>一言プロフィール</h6>
        <p>この店の店主です。花を大事にしてくれる人を募集しています。</p>
    </div>
@endsection