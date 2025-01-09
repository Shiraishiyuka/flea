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
    public function edit(Request $request , $product_id) {
        $user = auth()->user(); // ログインユーザー情報

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
        ]);

        // 住所を更新または新規作成
        $address = Address::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $product_id],
            $request->only(['post_code', 'address', 'building'])
        );


        return view('address', compact('address', 'product'));
        }




    public function update(Request $request)
    {
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
        ]);

        // 住所を更新または新規作成
        Address::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $product_id],
            $request->only(['post_code', 'address', 'building'])
        );

        return redirect()->route('purchase', ['id' => $product_id])->with('success', '住所情報が更新されました。');
    }
}
