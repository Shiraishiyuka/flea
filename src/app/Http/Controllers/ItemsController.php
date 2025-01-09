<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth; // Auth ファサードを正しくインポート
use App\Models\User;
use App\Models\Userprofile;
use App\Models\Product;
use App\Models\Interaction;

class ItemsController extends BaseController
{
    public function item(Request $request, $id) {

        // リダイレクト処理を呼び出し
        $redirect = $this->handleRedirects($request);
        if ($redirect) {
            return $redirect;
        }

        // 検索処理を呼び出し
        $products = $this->getProducts($request);
        

        // 必要な変数をビューに渡す
        $tab = $request->get('tab', 'recommend');
        $searchQuery = $request->input('search', '');
        
        // 商品情報と関連するコメント・ユーザー情報をロード
        $product = Product::with(['interactions.user.userprofile'])->findOrFail($id);
        $userprofile = Auth::user()->userProfile ?? null; // ログインユーザーのプロフィール


    
    
        return view('items', compact('product', 'tab', 'searchQuery', 'userprofile'));


    }


    public function like($id)
    {
        // 認証済みのユーザーかどうかチェック
        if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        // ユーザーが既にいいねしているかを確認
        $existingLike = Interaction::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->where('type', 'like')
            ->first();

        if ($existingLike) {
        $existingLike->delete(); // いいね解除
            } else {
            Interaction::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'type' => 'like',
            ]);
        }

        return redirect()->back();


    }

    public function comment(CommentRequest $request, $id)
    {
        // 非ログインユーザーへの対応
        if (!auth()->check()) {
        return redirect()->back()->withErrors(['comment' => 'コメントを送信できるのはユーザーのみです。']);
        }
    
        \Log::info('Comment request received', [
        'user_id' => auth()->id(),
        'product_id' => $id,
        'comment' => $request->comment,
        ]);

        $request->validate([
        'comment' => 'required|string|max:255',
        ]);

        Interaction::create([
        'user_id' => auth()->id(),
        'product_id' => $id,
        'type' => 'comment',
        'comment' => $request->comment,
        ]);

        $product = Product::with(['interactions.user.userprofile'])->findOrFail($id);

        $userprofile = Auth::user()->userProfile; // 現在のユーザーのプロフィールを取得

        foreach ($product->interactions as $interaction) {
            $interaction->user->profile_image_path = $interaction->user->userprofile->profile_image_path
                ? 'storage/profile_images/' . $interaction->user->userprofile->profile_image_path
                : 'images/default-profile.png'; // デフォルト画像
        }

        return view('items', compact('product','userprofile'));
}

}