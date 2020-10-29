@extends('auth.auth_common')

@section('title', 'Reset Password Page')
@section('auth_page_title', 'Reset Password')
@section('auth_anothor_page', 'Login')
@section('auth_anothor_link', '../login')
@section('auth_login_title', 'Reset Password')

@section('contents')
<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <p>{{ __('E-Mail Address') }}</p>

    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

    @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
    

    <button id="login_submit" type="submit" class="green_button">
        {{ __('Send Password Reset Link') }}
    </button>

</form>
               
@endsection
