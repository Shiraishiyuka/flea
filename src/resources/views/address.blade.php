@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}" />
<link rel="stylesheet" href="{{ asset('css/header.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection

@section('content')
<form action="{{ route('update', ['product_id' => $product->id]) }}" method="post">
    @csrf
    <p>住所の変更</p>
    <div class="col">
        <div class="form_box">
            <label>郵便番号<input type="text" class="text" name="post_code"></label>
            <div class="form_error">@error('post_code') {{ $message }} @enderror</div>
        </div>
        <div class="form_box">
            <label>住所<input type="text" class="text" name="address"></label>
            <div class="form_error">@error('address') {{ $message }} @enderror</div>
        </div>
        <div class="form_box">
            <label>建物名<input type="text" class="text" name="building"></label>
            <div class="form_error">@error('building') {{ $message }} @enderror</div>
        </div>
    </div>
    <div class="button">
        <button type="submit" class="button-submit">更新する</button>
    </div>
</form>
@endsection