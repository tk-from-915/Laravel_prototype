@extends('admin.admin_common')

@section('admin_page_title', 'User作成')

@section('content')
<form method="POST" action="" id="user_forms">
@csrf
    <div class="form_block">
        <p>ユーザ名</p>
        <input type="text"　id="user_name_form" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
            <p class="red">{{ $errors->first('name') }}</p>
        @endif
    </div>
    <div class="form_block">
        <p>登録メールアドレス</p>
        <input type="email" id="user_mail_form" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <p class="red">{{ $errors->first('email') }}</p>
        @endif
    </div>
    <div class="form_block">
        <p>登録パスワード</p>
        <input type="password"  class="user_password_form form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
        @if ($errors->has('password'))
            <p class="red">{{ $errors->first('password') }}</p>
        @endif
    </div>
    <div class="form_block">
        <p>確認用パスワード</p>
        <input id="password-confirm" type="password" class="user_password_form form-control" name="password_confirmation" required>
    </div>
    <div class="form_block">
        <p>権限</p>
        <select name="authority" id="user_authority">
            <option value="0">投稿者</option>
            <option value="1">管理者</option>
        </select>
    </div>
    <div class="form_block">
        <p>一言メッセージ</p>
        <textarea name="messeage" id="user_messeage_form"></textarea>
    </div>
    <div class="form_block">
        <button type="submit" id="post_send" class="green_button　whitelink">
            {{ __('Update') }}
        </button>
    </div>
</form>
@endsection