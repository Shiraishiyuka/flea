<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
use App\Models\address;
use App\Models\Product;
use App\Models\UserProfile;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class PurchaseController extends BaseController
{
    public function purchase(Request $request, $id)
    {
    $user = auth()->user();
    $product = Product::find($id);

    if (!$product) {
        abort(404, '商品が見つかりません');
    }

    // 売り切れチェック
    if ($product->address) {
        return redirect()->back()->with('error', 'この商品は売り切れです。');
    }

    if ($request->isMethod('get')) {
        // 購入ページを表示
        $address = Address::where('user_id', $user->id)->where('product_id', $product->id)->first();
        $userprofile = $user->userProfile; // ユーザープロフィール情報を取得
        return view('purchase', compact('product', 'address', 'userprofile'));
    }
    $profile = $user->userProfile;

    // プロフィールが存在しない場合はデフォルト値を設定
    $post_code = $profile->post_code ?? '未設定';
    $address = $profile->address ?? '未設定';
    $building = $profile->building ?? '未設定';

    // POSTリクエストの処理
    $validated = $request->validate([
        'payment_method' => 'required|in:コンビニ払い,カード払い',
    ]);

    if ($validated['payment_method'] === 'カード払い') {
        // Stripe Checkoutセッションを作成
        return $this->processStripePayment($product);
    }

    // コンビニ払いの処理
    Address::updateOrCreate(
    ['user_id' => $user->id, 'product_id' => $product->id],
    [
        'payment_method' => 'コンビニ払い',
        'post_code' => $post_code,
        'address' => $address,
        'building' => $building,
    ]
    );
    return redirect()->route('mypage')->with('success', '購入が完了しました');
    }

    private function processStripePayment($product)
    {
    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

     // Success URLをログに記録
    \Log::info('Success URL:', ['url' => route('success', ['product_id' => $product->id])]);

    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $product->price * 100,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('success', ['product_id' => $product->id]),
    ]);

    return redirect($session->url);
    }

    public function success(Request $request)
    {
    $user = auth()->user();
    $product_id = $request->query('product_id'); // success_urlからクエリパラメータを取得

    if (!$product_id) {
        return redirect()->route('mypage')->with('error', '決済情報が見つかりません。');
    }

    $product = Product::find($product_id);

    if (!$product) {
        return redirect()->route('mypage')->with('error', '商品が見つかりません。');
    }

    // ユーザープロフィールから住所情報を取得
    $profile = $user->userProfile;

    // プロフィールが存在しない場合はデフォルト値を設定
    $post_code = $profile->post_code ?? '未設定';
    $address = $profile->address ?? '未設定';
    $building = $profile->building ?? '未設定';

    // 決済成功時のデータ保存
    Address::updateOrCreate(
        ['user_id' => $user->id, 'product_id' => $product_id],
        [
            'payment_method' => 'カード払い', // カード払い固定
            'post_code' => $post_code,
            'address' => $address,
            'building' => $building,
        ]
    );

    return redirect()->route('mypage')->with('success', '購入が完了しました');
    }

    public function cancel()
    {
    return redirect()->route('mypage')->with('error', 'カード決済がキャンセルされました。');
    }
}


