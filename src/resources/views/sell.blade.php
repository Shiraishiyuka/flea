@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
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

    
    <form class="sell_form" action="" method="post">
        @csrf
        <p>商品の出品</p>

        <div class="image">
            <label>商品画像</label>
            <div class="image_upload">
                <div class="inner_text">画像を選択する</div>
            </div>
        </div>

    <div class="col">

    <h2>商品の詳細</h2>

        <label>カテゴリー</label>
    <div class="category-container">

        <div class="category-box">
        <input type="radio" name="category" value="ファッション">
        <span>ファッション</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="家電">
        <span>家電</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="インテリア">
        <span>インテリア</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="レディース">
        <span>レディース</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="メンズ">
        <span>メンズ</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="コスメ">
        <span>コスメ</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="本">
        <span>本</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="ゲーム">
        <span>ゲーム</span>
        </div>


        <div class="category-box">
        <input type="radio" name="category" value="スポーツ">
        <span>スポーツ</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="キッチン">
        <span>キッチン</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="ハンドメイド">
        <span>ハンドメイド</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="アクセサリー">
        <span>アクセサリー</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="おもちゃ">
        <span>おもちゃ</span>
        </div>

        <div class="category-box">
        <input type="radio" name="category" value="ベビー・キッズ">
        <span>ベビー・キッズ</span>
        </div>

    </div>


    <label>商品の状態</label>
    <select name="select" class="text">
        <option value="良好">良好</option>
        <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
        <option value="やや傷や汚れあり">やや傷や汚れあり</option>
        <option value="状態が悪い">状態が悪い</option>
    </select>


    <div class="form_box">
    <label>商品名<input type="text"  class="text" name="name"></label>
    <div class="form_error">
        <!--エラー-->
    </div>
    </div>

    <div class="form_box">
    <label>商品の説明
    <textarea name="textarea" class="text" cols="40" rows="8"></textarea></label>
    <div class="form_error">
        <!--エラー-->
    </div>
    </div>

    <div class="form_box">
    <label>販売価格<input type="password" class="text" name="building"></label>
    <div class="form_error">
        <!--エラー-->
    </div>
    </div>
</div>

<div class="button">
        <button class="button-submit">出品する</button>
    </div>

    </form>

@endsection


