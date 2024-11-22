@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('header')
<div class="search">
</div>

<div class="form">
    <form action="" method="post">
        @csrf
        <input class="form_item" type="submit" value="ログアウト" name="logout">
        <input class="form_item" type="submit" value="マイページ" name="mypage">
        <input class="form_item" type="submit" value="出品" name="Listing">
    </form>
</div>

@endsection

@section('content')

    
    <form class="mypage_form" action="" method="post">
        @csrf
        <p>プロフィール設定</p>
    <div class="icon-image">
        <div class="image-preview">
            <div class="image-preview_icon"></div>
            <div class="select">画像を選択</div>

        </div>

    </div>
    <div class="col">
    <label>ユーザー名</label><input type="text" class="text" name="name">
    <div class="form_error">
        <!--エラー-->
    </div>

    <label>郵便番号<input type="text"  class="text" name="post_code"></label>
    <div class="form_error">
        <!--エラー-->
    </div>

    <label>住所<input type="password"  class="text" name="address"></label>
    <div class="form_error">
        <!--エラー-->
    </div>

    <label>建物名<input type="password" class="text" name="building"></label>
    <div class="form_error">
        <!--エラー-->
    </div>
</div>

<div class="button">
        <button class="button-submit">更新する</button>
    </div>

    </form>

@endsection


