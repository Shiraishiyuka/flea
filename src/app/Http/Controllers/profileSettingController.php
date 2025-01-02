<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\UserProfile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class profileSettingController extends BaseController
{
    /*ユーザーコントローラー*/

    public function profile_setting()
    {
        return view('profile_setting');

        
    }

    public function saveProfile(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'post_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $userProfile = $user->userProfile; // リレーションで取得

        if (!$userProfile) {
            // プロファイルが存在しない場合、新規作成
            $userProfile = new UserProfile();
            $userProfile->user_id = $user->id;
        }

        // プロフィール画像の処理
        if ($request->hasFile('profile_image')) {
    // 古い画像を削除
    if ($userProfile->profile_image_path && Storage::disk('public')->exists($userProfile->profile_image_path)) {
        Storage::disk('public')->delete($userProfile->profile_image_path);
    }

    $uploadedFile = $request->file('profile_image');
    $path = $uploadedFile->store('profile_images', 'public');

    // Intervention Imageを使用してトリミングとリサイズ処理
    $image = Image::make(Storage::disk('public')->path($path));
    $size = min($image->width(), $image->height());
    $image->crop($size, $size); // 正方形に切り抜き
    $image->resize(120, 120);   // 適切なサイズにリサイズ
    $image->save();

    $userProfile->profile_image_path = $path; // $path には 'profile_images/...'

}

        // フォームから受け取ったデータを保存
        $userProfile->name = $request->name;
        $userProfile->post_code = $request->post_code;
        $userProfile->address = $request->address;
        $userProfile->building = $request->building;

        $userProfile->save();

        $redirect = $this->handleRedirects($request);
        if ($redirect) {
            return $redirect;
        }

        return redirect()->route('home_route')->with('status', 'プロフィールが保存されました。');
    }
}



/*
インポート
use Illuminate\Support\Str;　文字列操作に便利なヘルパークラスStrをインポート
例としてンダム文字列生成やスネークケース変換などに使用できる

use Intervention\Image\Facades\Image;　　画像操作ライブラリIntervention Imageのファサードをインポート
トリミングやリサイズなどの処理に使用

use Illuminate\Support\Facades\Storage;　ストレージ操作を簡単に行うためのLaravelのStorageファサードをインポート
ここでは、プロフィール画像のアップロード・削除に使用


ユーザー情報の取得とプロファイルの確認
$user = Auth::user();　現在、ログインしているユーザーを取得
Auth::user()が返すのは現在認証されているユーザーのインスタンス

$userProfile = $user->userProfile;　ログインユーザーに関連付けられたUserProfileモデルのインスタンスを取得
「$userからuserProfileのデータを取得し、$userProfileに代入する


if (!$userProfile) {
    $userProfile = new UserProfile();
    $userProfile->user_id = $user->id;
}
UserProfileがまだ存在しない場合、新しいインスタンスを作成し、user_idを現在のユーザーIDで設定


if ($request->hasFile('profile_image')) {　フォームに画像ファイルが送信されているか確認
if ($userProfile->profile_image_path && Storage::disk('public')->exists($userProfile->profile_image_path)) {
    Storage::disk('public')->delete($userProfile->profile_image_path);
}

既存のプロフィール画像がストレージに存在する場合、それを削除する。
$uploadedFile = $request->file('profile_image');
$path = $uploadedFile->store('profile_images', 'public');


新しい画像をアップロードし、profile_imagesディレクトリに保存
$image = Image::make(Storage::disk('public')->path($path));


アップロードした画像をIntervention Imageで操作できる形式に読み込みます。
$size = min($image->width(), $image->height());
$image->crop($size, $size);
$image->resize(120, 120);
$image->save();
画像を正方形にトリミングし、120×120ピクセルにリサイズします。その後、保存します。


$userProfile->profile_image_path = $path;
プロフィール画像のパスを$userProfileに保存できる。


その他のフォームデータを保存
$userProfile->name = $request->name;
$userProfile->post_code = $request->post_code;
$userProfile->address = $request->address;
$userProfile->building = $request->building;
フォームから送信されたデータを$userProfileの各フィールドに代入します

$userProfile->save();
プロフィール情報をデータベースに保存


以下、コードの一行ずつ詳しい解説と、質問への回答を行います。

Namespaceと使用するクラスのインポート部分
php
コードをコピーする
namespace App\Http\Controllers;
コントローラーが属する名前空間を定義しています。Laravelの標準的な場所であるApp\Http\Controllersに含まれています。
php
コードをコピーする
use Illuminate\Http\Request;
HTTPリクエストを扱うためのクラスです。ユーザーの入力データ（フォーム送信など）を取得する際に使用します。
php
コードをコピーする
use Illuminate\Support\Facades\Auth;
認証機能に関連する操作を提供するLaravelのAuthファサードをインポートしています。
php
コードをコピーする
use App\Http\Controllers\BaseController;
他のコントローラーと共通の機能を持たせるために継承するBaseControllerを使用しています。
php
コードをコピーする
use App\Models\User;
Userモデルをインポートしています。ユーザー情報の取得や更新に使用されます。
php
コードをコピーする
use Illuminate\Support\Str;
文字列操作に便利なヘルパークラスStrをインポートしています。例として、ランダム文字列生成やスネークケース変換などに使用できます。
このコード内では使われていませんが、ファイル名生成やユニークID生成などで用いられることが多いです。
php
コードをコピーする
use App\Models\UserProfile;
UserProfileモデルをインポートしています。ユーザーのプロフィール情報を保存・取得します。
php
コードをコピーする
use Intervention\Image\Facades\Image;
画像操作ライブラリIntervention Imageのファサードをインポートしています。トリミングやリサイズなどの処理に使用されます。
このコードでは、プロフィール画像のトリミングやリサイズ処理に使われています。
php
コードをコピーする
use Illuminate\Support\Facades\Storage;
ストレージ操作を簡単に行うためのLaravelのStorageファサードをインポートしています。
このコードでは、プロフィール画像のアップロード・削除に使用されています。
クラス定義部分
php
コードをコピーする
class profileSettingController extends BaseController
プロフィール設定を行うコントローラーprofileSettingControllerを定義しています。
BaseControllerを継承しており、基本機能や共通処理を利用できるようにしています。
profile_settingメソッド
php
コードをコピーする
public function profile_setting()
{
    return view('profile_setting');
}
profile_settingビューを表示するためのメソッドです。
特にデータ処理は行わず、ビューを単純に返すだけの役割を持っています。
saveProfileメソッド
バリデーション処理
php
コードをコピーする
public function saveProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'post_code' => 'nullable|string|max:10',
        'address' => 'nullable|string|max:255',
        'building' => 'nullable|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
}
フォームから送信されたデータを検証する部分です。
各フィールドに対して次の条件を定義しています：
name: 必須 (required)、文字列 (string)、最大255文字。
post_code, address, building: それぞれ任意入力（nullable）で、文字列かつ制限された最大文字数。
profile_image: 任意入力で画像ファイル形式限定（JPEG, PNG, JPG, GIF）。最大サイズは2MB。
ユーザー情報の取得とプロファイルの確認
php
コードをコピーする
$user = Auth::user();
現在ログインしているユーザーを取得します。
Auth::user()が返すのは現在認証されているユーザーのインスタンスです。
php
コードをコピーする
$userProfile = $user->userProfile;
ログインユーザーに関連付けられたUserProfileモデルのインスタンスを取得します。
正しい解釈です：「$userからuserProfileのデータを取得し、$userProfileに代入する。」
php
コードをコピーする
if (!$userProfile) {
    $userProfile = new UserProfile();
    $userProfile->user_id = $user->id;
}
UserProfileがまだ存在しない場合、新しいインスタンスを作成し、user_idを現在のユーザーIDで設定します。
プロフィール画像の処理
php
コードをコピーする
if ($request->hasFile('profile_image')) {
フォームに画像ファイルが送信されているか確認します。
php
コードをコピーする
if ($userProfile->profile_image_path && Storage::disk('public')->exists($userProfile->profile_image_path)) {
    Storage::disk('public')->delete($userProfile->profile_image_path);
}
既存のプロフィール画像がストレージに存在する場合、それを削除します。
php
コードをコピーする
$uploadedFile = $request->file('profile_image');
$path = $uploadedFile->store('profile_images', 'public');
新しい画像をアップロードし、profile_imagesディレクトリに保存します。
php
コードをコピーする
$image = Image::make(Storage::disk('public')->path($path));
アップロードした画像をIntervention Imageで操作できる形式に読み込みます。
php
コードをコピーする
$size = min($image->width(), $image->height());
$image->crop($size, $size);
$image->resize(120, 120);
$image->save();
画像を正方形にトリミングし、120×120ピクセルにリサイズします。その後、保存します。
php
コードをコピーする
$userProfile->profile_image_path = $path;
プロフィール画像のパスを$userProfileに保存します。
その他のフォームデータを保存
php
コードをコピーする
$userProfile->name = $request->name;
$userProfile->post_code = $request->post_code;
$userProfile->address = $request->address;
$userProfile->building = $request->building;
フォームから送信されたデータを$userProfileの各フィールドに代入します。
php
コードをコピーする
$userProfile->save();
プロフィール情報をデータベースに保存します。


$redirect = $this->handleRedirects($request);
if ($redirect) {
    return $redirect;
}
    handleRedirectsメソッドで追加のリダイレクトが必要か確認し、必要ならリダイレクト


    return redirect()->route('home_route')->with('status', 'プロフィールが保存されました。');
処理完了後、home_routeにリダイレクトし、ステータスメッセージをセッションに保存

*/