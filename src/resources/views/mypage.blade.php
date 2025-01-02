@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
<link rel="stylesheet" href="{{ asset('css/header.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection

@section('content')

<div class="mypage-form">

<form action="{{ route('profile_setting') }}" method="get">
    @csrf
    <div class="user-page">
        <div class="user">
            <div class="icon-image">
                <div class="image-preview">
                    <img src="{{ asset($userprofile && $userprofile->profile_image_path 
                        ? 'storage/' . $userprofile->profile_image_path 
                        : 'default.png') }}" 
                        alt="アイコン画像" class="image-preview_icon">
                </div>
            </div>
            <label class="user-name">{{ $userprofile->name }}</label>
        </div>
        <input class="back" type="submit" value="プロフィールを編集">
    </div>
</form>

<!-- タブ切り替え -->
<div class="text">
    <div class="text_inner">
        <a href="{{ route('mypage.sell') }}" class="tab {{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage.buy') }}" class="tab {{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>
</div>

<!-- 商品一覧 -->
<div class="items">
    @if ($products->isEmpty())
        <p>表示する商品がありません。</p>
    @else
        @foreach ($products as $product)
        <div class="box">
            <div class="item_box">
                <a href="{{ route('items', ['id' => $product->id]) }}">
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
                </a>
            </div>
            <label><a href="{{ route('items', ['id' => $product->id]) }}">{{ $product->name }}</a></label>
        </div>
        @endforeach
    @endif
</div>

</div>

@endsection