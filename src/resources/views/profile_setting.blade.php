@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile_setting.css') }}" />
<link rel="stylesheet" href="{{ asset('css/header.css') }}" />
@endsection

@section('header')
@include('partials.header') <!-- 共通ヘッダーを呼び出し -->
@endsection

@section('content')

<div class="icon">
    <form class="profile_setting" action="{{ route('mypage.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        <p>プロフィール設定</p>
        
        <div class="icon-image">
            <div class="image-preview">
                <img id="preview" src="{{ asset(Auth::user()->userProfile->profile_image_path ?? 'default.png') }}" class="image-preview_icon">
            </div>

            {{-- カスタムボタンでファイル選択 --}}
            <label class="back" for="profile-image-input">画像を選択する</label>
            <input type="file" id="profile-image-input" name="profile_image" accept="image/*">
        </div>
        <div class="col">
            <label>ユーザー名</label>
            <input type="text" class="text" name="name" value="{{ Auth::user()->userProfile->name ?? '' }}">
            <div class="form_error"></div>

            <label>郵便番号</label>
            <input type="text" class="text" name="post_code" value="{{ Auth::user()->userProfile->post_code ?? '' }}">
            <div class="form_error"></div>

            <label>住所</label>
            <input type="text" class="text" name="address" value="{{ Auth::user()->userProfile->address ?? '' }}">
            <div class="form_error"></div>

            <label>建物名</label>
            <input type="text" class="text" name="building" value="{{ Auth::user()->userProfile->building ?? '' }}">
            <div class="form_error"></div>
        </div>
        <div class="button">
            <button class="button-submit">更新する</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('profile-image-input').addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result; // 選択した画像をプレビュー
            };
            reader.readAsDataURL(file);
        }
    });
</script>



@endsection


