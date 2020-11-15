@extends('admin.admin_common')

@section('admin_page_title', 'プロフィール編集')

@section('content')
<form method="POST" action="{{ route('users.update',['user' => $user]) }}" id="user_forms">
@method('PUT')
@csrf
    <div class="form_block">
        <p>ユーザ名</p>
        <input type="text"　id="user_name_form" name="name" value="{{ old('name',$user->name) }}" required autofocus>
        @if ($errors->has('name'))
            <p class="red">{{ $errors->first('name') }}</p>
        @endif
    </div>
    <div class="form_block">
        <p>登録メールアドレス</p>
        <input type="email" id="user_mail_form" name="email" value="{{ old('email',$user->email) }}" required>
        @if ($errors->has('email'))
            <p class="red">{{ $errors->first('email') }}</p>
        @endif
    </div>
    <div class="form_block">
        <p>登録パスワード</p>
        <input type="password"  class="user_password_form" name="password" required>
        @if ($errors->has('password'))
            <p class="red">{{ $errors->first('password') }}</p>
        @endif
    </div>
    <div class="form_block">
        <p>確認用パスワード</p>
        <input id="password-confirm" type="password" class="user_password_form" name="password_confirmation" required>
    </div>
    <div class="form_block">
        <p>権限</p>
        <select name="authority" id="user_authority">
            @if (old('authority',$user->authority))
                @if (old('authority',$user->authority) == 0)
                    <option value="0" selected>投稿者</option>
                    <option value="1">管理者</option>
                @else
                    <option value="0">投稿者</option>
                    <option value="1" selected>管理者</option>
                @endif                     
            @else
                @if (old('authority') == 0)
                    <option value="0" selected>投稿者</option>
                    <option value="1">管理者</option>
                @else
                    <option value="0">投稿者</option>
                    <option value="1" selected>管理者</option>   
                @endif
            @endif
        </select>
    </div>
    <div class="form_block">
        <p>一言メッセージ</p>
        <textarea name="messeage" id="user_messeage_form">{{ old('messeage',$user->messeage) }}</textarea>
        @if ($errors->has('messeage'))
            <p class="red">{{ $errors->first('messeage') }}</p>
        @endif
    </div>
    <div class="form_block">
        <button type="submit" id="send" class="green_button whitelink">
            {{ __('Update') }}
        </button>
    </div>
</form>
@endsection