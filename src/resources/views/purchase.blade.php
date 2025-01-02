@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
<link rel="stylesheet" href="{{ asset('css/header.css') }}" />
@endsection

@section('header')
@include('partials.header') <!-- 共通ヘッダーを呼び出し -->
@endsection

@section('content')
<div class="purchase-form">

    <div class="Purchased-products">
        <div class="items">
        <!-- 商品画像 -->
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="product-image">
            <div class="product-information">

                <label class="product-name">{{ $product->name }}</label>
                <label class="product-price">{{ $product->price }}</label>
            </div>
        
    </div>


<div class="payment">
    <form action="{{ route('purchase', ['id' => $product->id]) }}" method="post">
        @csrf
    <span class="text">支払い方法</span>
        <select name="payment_method_display" id="payment-method" class="payment-method" required>
        <option value="コンビニ払い">コンビニ払い</option>
        <option value="カード払い">カード払い</option>
    </select>
</form>

</div>

    <div class="address-box">
        <div class="address-form">
            <span class="text">配送先</span>
             <form action="{{ route('address.edit', ['product_id' => $product->id]) }}" method="get">
            @csrf
            <button type="submit" class="address-back" name="address">変更する</button>
</form>
    </div>
    <div class="form-text">
    <span class="address">{{ $address->post_code }}</span>
    <span class="address">{{ $address->address }}</span>
    <span class="address">{{ $address->building }}</span>
    </div>

    </div>


</div>

<div class="Purchase-information">
    <div class="flex-box">
        <div class="box">商品代金</div>
        <div class="box">{{$product->price}}</div>
        <div class="box">支払い方法</div>
        <div class="box" id="selected-payment-method">コンビニ払い</div>
    </div>

        <input type="hidden" id="payment-method-hidden" name="payment_method" value="コンビニ払い">
    <div class="purchase-button">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button type="submit" class="purchase" name="post">購入する</button>


    </div>
</form>
</div>

</div>

<script>
    document.getElementById('payment-method').addEventListener('change', function() {
        const selectedMethod = this.value;
        document.getElementById('selected-payment-method').innerText = selectedMethod;
        document.getElementById('payment-method-hidden').value = selectedMethod;
    });
</script>

@endsection