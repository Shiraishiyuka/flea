@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')

    
    <form class="register_form" action=/login method="post">
        @csrf

        <p>会員登録</p>
    <div class="register-content">
    <div class="col">
    <label>ユーザー名</label><input type="text" class="text" name="name">
    <div class="form_error">
        @error('name')
            {{ $message }}
            @enderror
    </div>


    <label>メールアドレス<input type="email"  class="text" name="email"></label>
    <div class="form_error">
         @error('email')
            {{ $message }}
            @enderror
    </div>

    <label>パスワード<input type="password"  class="text" name="password"></label> 
    <div class="form_error">
         @error('password')
            {{ $message }}
            @enderror
    </div>

    <label>確認用パスワード<input type="password" class="text" name="password_confirmation"></label>
    <div class="form_error">
        @error('password_confirmation')
            {{ $message }}
            @enderror
    </div>

    
</div>
<div class="button">
        <button class="button-submit">会員登録</button>
    </div>

  


<div class="return_button">
        <div class="login_button">
            <button class="login_button-submit" type="submit">ログインはこちら</button>
        </div>


  </form>

@endsection


