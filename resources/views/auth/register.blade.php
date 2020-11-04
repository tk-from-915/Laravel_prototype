@extends('auth.auth_common')

@section('title', 'Sign up Page')
@section('auth_page_title', 'Sign up')
@section('auth_anothor_page', 'Login')
@section('auth_anothor_link', 'login')
@section('auth_login_title', 'Create your Account')

@section('contents')
<form method="POST" action="{{ route('register') }}">
@csrf
    <p>user_name</p>
        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
            <p class="red">{{ $errors->first('name') }}</p>
        @endif
    <p>mail_adress</p>
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <p class="red">{{ $errors->first('email') }}</p>
        @endif
    <p>password</p>
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
        @if ($errors->has('password'))
            <p class="red">{{ $errors->first('password') }}</p>
        @endif
    <p>confirm password</p>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
    <p>User_authority</p>
        <select name="authority">
            <option value="0">投稿者</option>
            <option value="1">管理者</option>
        </select>
    <button type="submit" id="login_submit" class="green_button">
        {{ __('Sign up') }}
    </button>
@endsection