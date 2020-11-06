@extends('admin.admin_common')

@section('admin_page_title', 'User作成')

@section('content')
<form method="POST" action="" id="user_forms">
@csrf
    <div class="form_block">
        <p>ニックネーム</p>
        <input type="text" name="user_name"　id="user_name_form">
    </div>
    <div class="form_block">
        <p>登録メールアドレス</p>
        <input type="email" name="user_mail" id="user_mail_form">
    </div>
    <div class="form_block">
        <p>登録パスワード</p>
        <input type="password" name="user_password" id="user_password_form">
    </div>
    <div class="form_block">
        <p>権限</p>
        <select name="authority">
            <option value="0">投稿者</option>
            <option value="1">管理者</option>
        </select>
    </div>
    <div class="form_block">
        <input type="submit" id="post_send" class="green_button whitelink" value="Update">
    </div>
</form>
@endsection