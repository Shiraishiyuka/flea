@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('content')

    
    <form class="login_form" action="{{ route('login.show') }}" method="post">
        @csrf

        <p>ログイン</p>
    <div class="login-content">
    <div class="col">
    <label>ユーザー名/メールアドレス<input type="email"  class="text" name="email" value="{{ old('email') }}" /></label>
    <div class="form_error">
        @error('email')
            {{ $message }}
            @enderror
    </div>
</div>

    <label>パスワード<input type="password"  class="text" name="password"></label> 
    <div class="form_error">
        @error('password')
            {{ $message }}
            @enderror
    </div>


    
</div>
<div class="button">
        <button class="button-submit">ログインする</button>
    </div>

    </form>

<div class="return_button">
    <form action="{{ route('register') }}" method="get">
        <div class="register_button">
            <button class="register_button-submit" type="submit">会員登録はこちら</button>
        </div>






@endsection


