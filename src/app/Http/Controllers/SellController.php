<?php

namespace App\Http\Controllers;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\SellRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellController extends BaseController
{
    public function sell()
    {
        return view('sell');
    }

    public function store(SellRequest $request)
{
    // 画像のアップロード
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $relativePath = 'images/' . basename($path);
    } else {
        return redirect()->back()->withErrors(['image' => '画像ファイルがアップロードされていません']);
    }

    // バリデーション済みデータ
    $validated = $request->validated();

    // 商品データを保存
    $product = Product::create([
        'user_id' => Auth::id(),
        'name' => $validated['name'],
        'description' => $validated['description'],
        'category' => $validated['categories'],
        'condition' => $validated['condition'],
        'price' => $validated['price'],
        'image_path' => $relativePath,
    ]);

    // ログで確認
    \Log::info('商品データ: ', $product->toArray());

    // ホーム画面にリダイレクト
    return redirect()->route('home_route')->with('success', '商品が出品されました！');
}
}
