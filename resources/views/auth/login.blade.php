@extends('auth.auth_common')

@section('auth_page_title', 'Login')
@section('auth_anothor_page', 'Sign up')
@section('auth_anothor_link', 'register')
@section('auth_login_title', 'Login')

@section('contents')
    <form action="admin.html" >
        <p>user_name</p>
            <input type="text">
            <p class="red">user_nameは255字以内にしてください</p>
        <p>or<br>mail_adress</p>
            <input type="email">
            <p class="red">メールの形式ではありません。@をつけてください</p>
        <p>password</p>
            <input type="password">
            <p class="red">passwordは半角英数字にしてください</p>
        <input type="submit" name="login_submit" id="login_submit" class="green_button" value="Login">
        <p class="green_p"><a href="">パスワードを忘れた時は</a></p>
    </form>
@endsection
