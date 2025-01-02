<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth; // Auth ファサードを正しくインポート
use App\Models\User;
use App\Models\Product;
use App\Models\address;

class AddressController extends BaseController
{
    public function edit($product_id) {
        $user = auth()->user(); // ログインユーザー情報

        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        // 指定された商品の確認
        $product = Product::findOrFail($product_id); // 商品の存在確認


        // 商品に紐づく住所情報を取得または初期化
    $address = Address::firstOrNew(
        ['user_id' => $user->id, 'product_id' => $product_id],
        ['post_code' => '', 'address' => '', 'building' => '']
    );


    // アドレスが空の場合、ユーザープロファイルの値を設定
    if (!$address->exists) {
        $profile = $user->userProfile;
        $address->post_code = $profile->post_code ?? '';
        $address->address = $profile->address ?? '';
        $address->building = $profile->building ?? '';
    }

        return view('address', compact('address', 'product'));
    }




public function update(Request $request, $id) {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

          // リクエストから product_id を取得
    $product_id = $request->input('product_id');

    if (!$product_id) {
        return redirect()->back()->withErrors(['error' => '商品IDが見つかりません。']);
    }



        // バリデーション
        $request->validate([
            'post_code' => 'nullable|max:10',
            'address' => 'nullable|max:255',
            'building' => 'nullable|max:255',
        ], [
            
            'post_code.max' => '郵便番号は10文字以内で入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'building.max' => '建物名は255文字以内で入力してください。',
        ]);

        // 住所を更新または新規作成
    $address = Address::updateOrCreate(
        ['user_id' => $user->id, 'product_id' => $product_id],
        $request->only(['post_code', 'address', 'building'])
    );


    return redirect()->route('purchase', ['id' => $product_id])->with('success', '住所情報が更新されました。');

    }
}



/*Laravelの認証（Authentication）機能を簡単に利用するためのクラス
Authを使うことで、現在ログインしているユーザーや認証関連の操作を簡潔に記述できる。
主なメソッド
Auth::check():　現在ログインしているかどうかを確認
Auth::user():現在ログインしているユーザーの情報を取得します（ユーザーモデルのインスタンスを返します）。
Auth::id():
現在ログインしているユーザーのIDを取得します。
Auth::logout():
現在のユーザーをログアウトさせます。

使用例
use Illuminate\Support\Facades\Auth;

if (Auth::check()) {
    $user = Auth::user();
    echo "ログイン中のユーザー: " . $user->name;
} else {
    echo "ログインしていません。";
}



$product_idは、リクエストから渡されるデータ
ルート定義でパラメータとして指定され、コントローラのメソッドに渡される。

ルート例：Route::get('/product/{product_id}/edit', [ProductController::class, 'edit']);
{product_id}がURLパラメータとして指定される。
リクエストを受け取る際に、product_idの値がコントローラのeditメソッドに渡される。



product = Product::findOrFail($product_id); 
findOrFailの仕組み:

データベースから指定した主キー（ID）に対応するレコードを取得する。
レコードが見つからない場合、**404エラー（ModelNotFoundException）**を自動的にスローされる。


$address = Address::firstOrNew(
    ['user_id' => $user->id, 'product_id' => $product_id],
    ['post_code' => '', 'address' => '', 'building' => '']
);


firstOrNewは、指定した条件でレコードを検索し、見つからなかった場合に新しいモデルインスタンスを作成する。
検索条件:
['user_id' => $user->id, 'product_id' => $product_id]:
user_idとproduct_idが一致するレコードを検索

コードが存在する場合:
該当するAddressモデルのインスタンスを返す・

レコードが存在しない場合:
['post_code' => '', 'address' => '', 'building' => '']の値を持つ新しいモデルインスタンスを返す。
ここまでは。新しいインスタンスはまだデータベースには保存されていない、


アドレスが空の場合の設定
php
コードをコピーする
if (!$address->exists) {
    $profile = $user->userProfile;
    $address->post_code = $profile->post_code ?? '';
    $address->address = $profile->address ?? '';
    $address->building = $profile->building ?? '';
}

$address->exists の意味:

取得した$addressが既存のデータベースレコードかどうかを判定
true: データベースに保存済みのレコード。
false: 新しく作成されたインスタンス（まだ保存されていない）。

流れ:

$address->existsがfalseの場合（新規インスタンスの場合）:
$user->userProfileから値を取得。
それを$addressのプロパティに代入。
?? '':
$profile->post_codeなどがnullの場合に空文字を代入。



return view('address', compact('address', 'product')); の意味
viewメソッド:

指定されたビューをレンダリングし、HTTPレスポンスを返します。
compact関数:

指定した変数を連想配列としてビューに渡します。
この例では、以下の2つの変数をビューに渡します：
$address
$product
最終的な動作:

address.blade.phpビューが表示され、$addressと$productのデータを利用できます。

*/