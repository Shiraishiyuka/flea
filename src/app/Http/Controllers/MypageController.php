<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Models\Address;
use App\Models\UserProfile;
use App\Models\Product;
use Illuminate\Http\Request;

class MypageController extends BaseController
{
    public function mypage(Request $request) {

    $searchQuery = $request->input('search', '');
    $tab = $request->get('tab', 'sell'); // デフォルトは "sell"
    $products = collect(); // デフォルトの空コレクション
    $userprofile = Auth::user()->userProfile; // 現在のユーザーのプロフィールを取得


    if ($tab === 'buy') {
    $purchasedProductIds = Address::where('user_id', Auth::id())->pluck('product_id'); // Addressテーブルからproduct_idを取得
    $query = Product::whereIn('id', $purchasedProductIds); // Productテーブルから該当する商品を取得
    } elseif ($tab === 'sell') {
    $query = Product::where('user_id', Auth::id());
    } else {
    $query = null;
    }


    
    if (isset($query) && !empty($searchQuery)) {
        $query->where('name', 'LIKE', "%{$searchQuery}%");
    }

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
