@extends('auth.auth_common')

@section('title', 'Sign up Page')
@section('auth_page_title', 'Sign up')
@section('auth_anothor_page', 'Login')
@section('auth_anothor_link', 'login')
@section('auth_login_title', 'Create your Account')

@section('contents')
    <p>user_name</p>
        <input type="text">
    <p>mail_adress</p>
        <input type="email">
    <p>password</p>
        <input type="password">
    <p>confirm password</p>
        <input type="password">
    <p>Authority</p>
        <input type="password">
    <input type="submit" name="login_submit" id="login_submit" class="green_button" value="Sign up">
@endsection