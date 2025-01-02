@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
<link rel="stylesheet" href="{{ asset('css/header.css') }}" />
@endsection

@section('header')
@include('partials.header') 
@endsection


@section('content')
<form class="sell_form" action="{{ route('sell.store') }}" method="post" enctype="multipart/form-data">
     @csrf
    <p>商品の出品</p>

    <div class="image">
        <label>商品画像</label>
        <div class="image_upload">
            <input type="file" name="image" id="image" accept="image/*" onchange="showFileName(event)">
            <div class="inner_text">画像を選択する</div>
        </div>

        <p id="file_name" style="margin-top: 10px; color: #333;"></p>
        </div>
        <div class="form_error">
          @error('image')
            <span class="error">{{ $message }}</span>
        @enderror
    </div>

        
        <script>
    function showFileName(event) {
        const input = event.target;
        const fileName = input.files.length > 0 ? input.files[0].name : 'ファイルが選択されていません';
        document.getElementById('file_name').textContent = fileName;
    }
</script>

    <div class="col">

    <div class="select-text">商品の詳細</div>

    <label>カテゴリー</label>
        <div class="category-container">
    @foreach (['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', '本', 'ゲーム', 'スポーツ', 'キッチン', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'] as $category)
    <label class="category-box">
        <input type="checkbox" name="categories[]" value="{{ $category }}"> <!-- 配列として送信 -->
        <span>{{ $category }}</span>
    </label>
    @endforeach
    <div class="form_error">
          @error('category')
                    <span class="error">{{ $message }}</span>
                @enderror
    </div>
</div>





    <label>商品の状態</label>
<select name="condition" class="noo">
    <option value="良好">良好</option>
    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
    <option value="状態が悪い">状態が悪い</option>
</select>
<div class="form_error">
          @error('condition')
                    <span class="error">{{ $message }}</span>
                @enderror
    </div>

    

    <div class="select-text">商品名と説明</div>
    <div class="form_box">
    <label>商品名<input type="text"  class="text" name="name"></label>
    <div class="form_error">
          @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
    </div>
    </div>

    <div class="form_box">
    <label>商品の説明
    <textarea name="description" class="textarea" cols="40" rows="8"></textarea></label>
    <div class="form_error">
          @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
    </div>
    </div>
    </div>

    <div class="form_box">
    <label>販売価格
                <input type="text" class="text" name="price">
            </label>
    <div class="form_error">
          @error('price')
                    <span class="error">{{ $message }}</span>
                @enderror
    </div>
    </div>
</div>

<div class="button">
        <button class="button-submit">出品する</button>
    </div>

    </form>



@endsection


