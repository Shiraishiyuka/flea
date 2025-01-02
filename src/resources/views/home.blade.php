@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/home.css') }}" />
<link rel="stylesheet" href="{{ asset('css/header.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection

@section('content')

<!-- タブ切り替え部分 -->
<div class="text">
    <div class="text_inner">
        <a href="{{ route('home_route') }}" 
           class="tab {{ $tab ?? '' === 'recommend' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ route('home_mylist') }}" 
           class="tab {{ $tab ?? '' === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>
</div>

<!-- 商品一覧部分 -->
<div class="items">
    @foreach ($products as $product)
        @if ($product->user_id !== Auth::id())
        <div class="box">
            <div class="item_box">
                @if ($product->address)
                    <!-- 購入済み商品の場合 -->
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <!-- 未購入商品の場合 -->
                    <a href="{{ route('items', ['id' => $product->id]) }}">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
                    </a>
                @endif
            </div>
            <label>
                @if ($product->address)
                    {{ $product->name }}
                @else
                    <a href="{{ route('items', ['id' => $product->id]) }}">{{ $product->name }}</a>
                @endif
            </label>
            @if ($product->address)
            <label>
                <span class="sold-out">売り切れ</span>
            </label>
            @endif
        </div>
        @endif
    @endforeach
</div>

@endsection