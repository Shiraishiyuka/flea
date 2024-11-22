@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}" />
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

    
    <form class="address_form" action="" method="post">
        @csrf
        <p>住所の変更</p>

    <div class="col">

    <div class="form_box">
    <label>郵便番号<input type="text"  class="text" name="post_code"></label>
    <div class="form_error">
        <!--エラー-->
    </div>
    </div>

    <div class="form_box">
    <label>住所<input type="password"  class="text" name="address"></label>
    <div class="form_error">
        <!--エラー-->
    </div>
    </div>

    <div class="form_box">
    <label>建物名<input type="password" class="text" name="building"></label>
    <div class="form_error">
        <!--エラー-->
    </div>
    </div>
</div>

<div class="button">
        <button class="button-submit">更新する</button>
    </div>

    </form>

@endsection


