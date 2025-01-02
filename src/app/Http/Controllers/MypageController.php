<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth; // Auth ファサードを正しくインポート
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Address;
use App\Models\UserProfile;
use App\Models\Product;
use Illuminate\Http\Request;

class MypageController extends BaseController
{
    public function mypage(Request $request) {

    $searchQuery = $request->input('search', ''); // 検索クエリの取得
    $tab = $request->get('tab', 'sell'); // デフォルトは "sell"
    $products = collect(); // デフォルトの空コレクション
    $userprofile = Auth::user()->userProfile; // 現在のユーザーのプロフィールを取得


// クエリビルダを作成
if ($tab === 'buy') {
    $purchasedProductIds = Address::where('user_id', Auth::id())->pluck('product_id'); // Addressテーブルからproduct_idを取得
    $query = Product::whereIn('id', $purchasedProductIds); // Productテーブルから該当する商品を取得
} elseif ($tab === 'sell') {
    $query = Product::where('user_id', Auth::id());
} else {
    $query = null;
}


     // 検索条件を適用
        if (isset($query) && !empty($searchQuery)) {
            $query->where('name', 'LIKE', "%{$searchQuery}%");
        }

        // クエリが定義されている場合、商品を取得
        if (isset($query)) {
            $products = $query->get();
        }

        $redirect = $this->handleRedirects($request);
        if ($redirect) {
            return $redirect;
        }
    



        return view('mypage', compact('products', 'tab', 'searchQuery', 'userprofile'));

    }

    // 出品商品ページ
    public function sell(Request $request)
    {
        $products = Product::where('user_id', Auth::id())->get(); // 出品商品の取得
        $userprofile = Auth::user()->userProfile; // プロフィールの取得
        $searchQuery = $request->input('search', ''); // 検索クエリ
        return view('mypage', compact('products', 'userprofile', 'searchQuery'))->with('tab', 'sell');
    }

    // 購入商品ページ
    public function buy(Request $request)
    {
        $purchasedProductIds = Address::where('user_id', Auth::id())->pluck('product_id');
        $products = Product::whereIn('id', $purchasedProductIds)->get(); // 購入商品の取得
        $userprofile = Auth::user()->userProfile; // プロフィールの取得
        $searchQuery = $request->input('search', ''); // 検索クエリ
        return view('mypage', compact('products', 'userprofile', 'searchQuery'))->with('tab', 'buy');
    }


}



/*
クラス定義
class MypageController extends BaseController

MypageControllerは、マイページ関連の処理を担当するコントローラーです。
BaseControllerを継承することで、基本的なコントローラー機能を利用します。


$searchQuery = $request->input('search', ''); // 検索クエリの取得
ユーザーが送信した検索クエリ（searchキーの値）を取得する。
デフォルトはから文字列

$tab = $request->get('tab', 'sell'); // デフォルトは "sell"
URLやリクエストで指定されたtabの値を取得

$products = collect(); // デフォルトの空コレクション
商品情報を格納する変数を空のコレクションとして初期化している

$userprofile = Auth::user()->userProfile; // 現在のユーザーのプロフィールを取得
現在ログイン中のユーザーのプロフィール情報を取得している。


タブに応じたクエリビルダの構築
if ($tab === 'buy') {　　　/*現在のタブがbuyであるかを確認
$purchasedProductIds = Address::where('user_id', Auth::id())->pluck('product_id'); 
/*Addressテーブルから、現在のユーザーが購入した商品のIDを取得します。

$query = Product::whereIn('id', $purchasedProductIds);
productテーブルから、取得した商品IDに一致する商品のデータを検索するクエリを作成する。

} elseif ($tab === 'sell') {
    $query = Product::where('user_id', Auth::id());
}
タブがsellの場合、現在のユーザーが出品した商品を検索するクエリを作成する。


} else {
    $query = null;
}
どちらのタブにも該当しない場合、クエリをnullにする。


検索条件の適用
if (isset($query) && !empty($searchQuery)) {
    $query->where('name', 'LIKE', "%{$searchQuery}%");
}
クエリが存在し、かつ検索クエリが空でない場合、商品名が検索キーワードを含む商品のみに絞り込む。


商品データの取得
if (isset($query)) {
    $products = $query->get();
}

クエリが存在する場合、データベースから商品データを取得し、$productsに格納する。

リダイレクトの処理
$redirect = $this->handleRedirects($request);
if ($redirect) {
    return $redirect;
}
追加のリダイレクト処理をhandleRedirectsメソッドで実行し、必要であればリダイレクトを行う。

return view('mypage', compact('products', 'tab', 'searchQuery', 'userprofile'));
ビューmypageをレンダリングし、取得したデータ（商品情報、タブ情報、検索クエリ、ユーザープロフィール）を渡す。

sellメソッド
$products = Product::where('user_id', Auth::id())->get();
現在のユーザーが出品した商品を取得する。

$userprofile = Auth::user()->userProfile;
現在のユーザーのプロフィールを取得

$searchQuery = $request->input('search', '');
検索クエリを取得

return view('mypage', compact('products', 'userprofile', 'searchQuery'))->with('tab', 'sell');
ビューmypageをレンダリングし、出品商品データとタブ情報（sell）を渡す。


buyメソッド
$purchasedProductIds = Address::where('user_id', Auth::id())->pluck('product_id');
現在のユーザーが購入した商品のIDを取得

$products = Product::whereIn('id', $purchasedProductIds)->get();
取得した商品IDに一致する商品データを取得


$userprofile = Auth::user()->userProfile;
現在のユーザーのプロフィールを取得

$searchQuery = $request->input('search', '');
検索クエリを取得

return view('mypage', compact('products', 'userprofile', 'searchQuery'))->with('tab', 'buy');
ビューmypageをレンダリングし、購入商品データとタブ情報（buy）を渡す。


*/