<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
use App\Models\address;
use App\Models\Product;
use App\Models\UserProfile;


class PurchaseController extends BaseController
{
   public function purchase(Request $request, $id)
    {
        $user = auth()->user(); // ログインユーザー
        $product = Product::find($id); // 商品データ

        if (!$product) {
            abort(404, '商品が見つかりません');
        }

        // リダイレクト処理を呼び出し
        $redirect = $this->handleRedirects($request);
        if ($redirect) {
            return $redirect;
        }

        $address = Address::where('user_id', $user->id)->where('product_id', $product->id)->first();
        if ($request->has('address')) {
            // 住所変更ページにリダイレクト
            return redirect()->route('address.edit', ['product_id' => $product->id]);
        }

        if ($request->isMethod('post')) {
            // 購入ボタンの処理
            $validated = $request->validate([
                'payment_method' => 'required|in:コンビニ払い,カード払い',
            ]);

            // Addressモデルを作成または更新
        $address = Address::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $product->id], // 条件: ユーザーと商品
            [
                'post_code' => $request->post_code ?? $product->user->userProfile->post_code ?? '未設定',
                'address' => $request->address ?? $product->user->userProfile->address ?? '未設定',
                'building' => $request->building ?? $product->user->userProfile->building ?? '未設定',
                'payment_method' => $validated['payment_method']
            ]
        );


            // マイページへリダイレクト
            return redirect()->route('mypage')->with('success', '購入が完了しました');
        }

        // 住所情報の取得または初期化
        $address = Address::where('user_id', $user->id)->first();
        if (!$address) {
            $address = new \stdClass();
            $profile = UserProfile::where('user_id', $user->id)->first();
            $address->post_code = $profile->post_code ?? '未設定';
            $address->address = $profile->address ?? '未設定';
            $address->building = $profile->building ?? '未設定';
        }

        return view('purchase', compact('product', 'address'));
    }
}





/*
$user = auth()->user();
auth()->user()は、Auth::user()と同じ機能をする。
auth()ヘルパーメソッドを使用して、現在認証されているログインユーザーの情報を取得します。そのデータを$userに代入している。
※このコードが実行されるためには、ユーザーがログインしている必要があります。ログインしていない場合、このメソッドはnullを返します。

$product = Product::find($id);
解釈: 商品モデルProductから、指定されたidに対応する商品データをデータベースから取得し、$productに代入


補足:
Product::find($id)は、主キー（通常はid）に基づいて1件のレコードを取得します。
指定されたidに対応するデータが存在しない場合、nullを返します。


if (!$product) {
    abort(404, '商品が見つかりません');
}
解釈: $productがnull、つまり商品データが見つからなかった場合、abort(404, '商品が見つかりません')を実行します。これにより、HTTPステータスコード404のエラーページが表示されます。
補足:
abort(404, '商品が見つかりません')は、Laravelのヘルパーメソッドで、404エラーを簡単に発生させることができます。
エラーメッセージ「商品が見つかりません」はデバッグやカスタムエラーページで使用されます。


$redirect = $this->handleRedirects($request);
解釈: BaseControllerで定義されたhandleRedirectsメソッドを呼び出してリダイレクト処理を行います。その結果を$redirectに代入
補足:
$redirectには、リダイレクトが必要な場合にリダイレクト応答オブジェクトが代入されます。リダイレクトが不要な場合はnullになります


if ($redirect) {
    return $redirect;
}
    釈: $redirectがnullでない場合、そのままリダイレクトを返します。これにより、処理を中断し、指定されたページにリダイレクト
    補足:
この仕組みは、例えば未認証状態で特定のページにアクセスしようとした場合や、特定の条件を満たさない場合に柔軟なリダイレクト処理を提供します



$address = Address::where('user_id', $user->id)->where('product_id', $product->id)->first();
釈:
Addressモデルを使用して、指定されたuser_idとproduct_idに一致するレコードを検索
最初に見つかったレコードを取得し、その結果を$addressに代入します。
データが存在しない場合、$addressにはnullが代入されます。
ポイント:
where('user_id', $user->id)：現在ログイン中のユーザーIDに基づく条件。
where('product_id', $product->id)：現在処理中の商品のIDに基づく条件。
first()：複数の結果があっても、最初の1件だけを取得。


if ($request->has('address')) {
解釈:
HTTPリクエストにaddressという名前のパラメータが含まれているかを確認します。
この場合、フォームやURLクエリパラメータにaddressが存在する場合にtrueを返します。
// 住所変更ページにリダイレクト
return redirect()->route('address.edit', ['product_id' => $product->id]);
解釈:
条件がtrueの場合、住所変更用のページにリダイレクトします。
route('address.edit', ['product_id' => $product->id])は、web.phpで定義されたaddress.editという名前のルートにリダイレクトし、product_idパラメータを渡します。


if ($request->isMethod('post')) {
解釈:
現在のリクエストのHTTPメソッドがPOSTであるかを確認します。
通常、POSTリクエストはフォームデータを送信する際に使用されます。
条件がtrueの場合、購入処理のロジックを実行します。

以下に、該当部分を1行ずつ詳しく解説します。

$address = Address::where('user_id', $user->id)->where('product_id', $product->id)->first();
解釈:
Addressモデルを使用して、指定されたuser_idとproduct_idに一致するレコードを検索します。
最初に見つかったレコードを取得し、その結果を$addressに代入します。
データが存在しない場合、$addressにはnullが代入されます。
ポイント:
where('user_id', $user->id)：現在ログイン中のユーザーIDに基づく条件。
where('product_id', $product->id)：現在処理中の商品のIDに基づく条件。
first()：複数の結果があっても、最初の1件だけを取得。
if ($request->has('address')) {
解釈:
HTTPリクエストにaddressという名前のパラメータが含まれているかを確認します。
この場合、フォームやURLクエリパラメータにaddressが存在する場合にtrueを返します。
php
コードをコピーする
// 住所変更ページにリダイレクト
return redirect()->route('address.edit', ['product_id' => $product->id]);
解釈:
条件がtrueの場合、住所変更用のページにリダイレクトします。
route('address.edit', ['product_id' => $product->id])は、web.phpで定義されたaddress.editという名前のルートにリダイレクトし、product_idパラメータを渡します。
if ($request->isMethod('post')) {
解釈:
現在のリクエストのHTTPメソッドがPOSTであるかを確認します。
通常、POSTリクエストはフォームデータを送信する際に使用されます。
条件がtrueの場合、購入処理のロジックを実行します。
$validated = $request->validate([...]);
解釈:
リクエストから送信されたデータをバリデーションします。
payment_methodが必須であり、指定された値（"コンビニ払い" または "カード払い"）のいずれかである必要があります。
バリデーションに失敗すると、Laravelは自動的にエラーメッセージを返し、処理を中断します。



$address = Address::updateOrCreate([...], [...]);
解釈:
Addressモデルを使用して、指定した条件に基づきレコードを更新または作成します。
第一引数：検索条件（user_idとproduct_id）。
第二引数：条件に一致するレコードが見つかった場合に更新するフィールド、見つからなかった場合に新規作成するフィールド。
ポイント:
updateOrCreateは、条件に合致するレコードが存在しない場合、自動的に新しいレコードを作成する便利なメソッドです。
?? '未設定'：該当データがない場合のデフォルト値を指定しています。


return redirect()->route('mypage')->with('success', '購入が完了しました');
解釈:
処理が成功した後、mypageという名前のルートにリダイレクトします。
セッションにsuccessという名前でメッセージ「購入が完了しました」を追加します。


$address = Address::where('user_id', $user->id)->first();
解釈:
現在ログイン中のユーザーIDに基づいてAddressモデルを検索し、最初のレコードを取得します。
該当レコードがない場合、$addressにnullを代入します。


if (!$address) {
解釈:
$addressがnullである場合、つまり該当する住所情報が存在しない場合に実行される処理を定義します。
$address = new \stdClass();
$profile = UserProfile::where('user_id', $user->id)->first();
解釈:
$addressに空のオブジェクト（stdClass）を作成して代入します。
ユーザーIDに基づき、UserProfileからユーザープロフィール情報を取得し、$profileに代入します。
php
コードをコピーする



$address->post_code = $profile->post_code ?? '未設定';
$address->address = $profile->address ?? '未設定';
$address->building = $profile->building ?? '未設定';
解釈:
プロフィール情報を$addressオブジェクトに代入します。
該当情報がない場合（nullの場合）は、デフォルト値「未設定」を使用します。


return view('purchase', compact('product', 'address'));
解釈:
purchaseビューを表示し、productとaddressのデータをビューに渡します。
compactは変数をキーと値のペアにしてビューに送る便利な関数です。

*/

