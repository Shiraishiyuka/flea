@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}" />
@endsection

@section('header')
<div class="search">
</div>

<div class="form">
    <form action="{{ route('mypage') }}" method="post">
        @csrf
        <input class="form_item" type="submit" value="ログアウト" name="logout">
        <input class="form_item" type="submit" value="マイページ" name="mypage">
        <input class="form_item" type="submit" value="出品" name="Listing">
    </form>
</div>

@endsection

@section('content')

<div class="text">
    <span class="red">おすすめ</span>
    <span class="list">マイリスト</span>
</div>

<div class="items">
    @for($i=0; $i < 7; $i++) 
    <div class="box">
    <div class="item_box">
        商品画像
    </div>
    <label>商品名</label>
    </div>
@endfor
</div>



@endsection


