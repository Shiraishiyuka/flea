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

    // 各コメントのユーザーのプロフィール画像パスを準備
    foreach ($product->interactions as $interaction) {
        $interaction->user->profile_image_path = $interaction->user->userprofile->profile_image_path
            ? 'storage/profile_images/' . $interaction->user->userprofile->profile_image_path
            : 'images/default-profile.png'; // デフォルト画像
    }

     return view('items', compact('product','userprofile'));
}

    
}





/*
リダイレクト処理はbaseコントローラーのhandleRedirectsを使用している。
$redirect = $this->handleRedirects($request);
if ($redirect) {
    return $redirect;
}


検索処理　baseコントローラーのメソッドを使用
$products = $this->getProducts($request);
BaseController の getProducts メソッドを呼び出して、条件に基づいた商品リストを取得

商品情報と関連データの取得
$product = Product::with(['interactions.user.userprofile'])->findOrFail($id);
関連するデータ（interactions, user, userprofile）を事前ロードしています。
interactions: ユーザーが行った「いいね」やコメントの情報。
user: コメントやいいねをしたユーザーの情報。
userprofile: ユーザーのプロフィール情報。


ログインユーザーのプロフィール取得
$userprofile = Auth::user()->userProfile ?? null;
現在ログインしているユーザーのプロフィール情報を取得します。
未ログインの場合は null を設定します


ビューへのデータ送信
return view('items', compact('product', 'tab', 'searchQuery', 'userprofile'));
商品情報、タブ情報、検索クエリ、ユーザーのプロフィール情報をビューに渡します。


like メソッド
商品に対して「いいね」または「いいね解除」を行う

まずはログインしているかをチェック
if (!auth()->check()) {
    return redirect()->route('login')->with('error', 'ログインしてください。');
}

既存の「いいね」を確認
$existingLike = Interaction::where('user_id', auth()->id())
    ->where('product_id', $id)
    ->where('type', 'like')
    ->first();

    Interaction モデルを使って、現在のユーザーがすでにこの商品を「いいね」しているかどうかを確認する


    いいねしている場合
    $existingLike->delete();　でいいねを解除している、

    いいねしていない場合
    Interaction::create([
    'user_id' => auth()->id(),
    'product_id' => $id,
    'type' => 'like',
]);
新たないいねを作成する。

return redirect()->back();
前のページにリダイレクトする。

*/


/*
commentメソッド
概要
商品にコメントを投稿します。
投稿されたコメントは商品ページに表示されます。

ログインチェック
if (!auth()->check()) {
    return redirect()->back()->withErrors(['comment' => 'コメントを送信できるのはユーザーのみです。']);
}
    いいねメソッドと同じ仕組みでログイン済みかを確認


リクエストログの確認
コメントリクエストの内容をログに記録　でバックやモニタリングに役立つ
\Log::info('Comment request received', [
    'user_id' => auth()->id(),
    'product_id' => $id,
    'comment' => $request->comment,
]);


コメントをInteraction モデルに保存
Interaction::create([
    'user_id' => auth()->id(),
    'product_id' => $id,
    'type' => 'comment',
    'comment' => $request->comment,
]);


商品とコメント情報を再取得
$product = Product::with(['interactions.user.userprofile'])->findOrFail($id);

プロフィール画像の設定
各コメントを投稿したユーザーのプロフィール画像パスを設定します。
プロフィール画像が存在しない場合は、デフォルト画像を使用します。
foreach ($product->interactions as $interaction) {
    $interaction->user->profile_image_path = $interaction->user->userprofile->profile_image_path
        ? 'storage/profile_images/' . $interaction->user->userprofile->profile_image_path
        : 'images/default-profile.png';
}

return view('items', compact('product','userprofile'));
商品情報とユーザーのプロフィール情報をビューに渡す。

*/