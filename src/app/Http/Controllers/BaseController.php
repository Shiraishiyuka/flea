<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Auth ファサードを正しくインポート
use App\Models\User;
use App\Models\Product;

class BaseController extends Controller
{
    protected function getProducts(Request $request)
    {
        $searchQuery = $request->input('search', ''); // デフォルトは空文字
        $tab = $request->get('tab', 'recommend');    // デフォルトは 'recommend'
        $products = collect();                       // 空のコレクションを初期値とする

        // タブ判定に基づくクエリの構築
        if ($tab === 'mylist') {
            if (Auth::check()) {
                // ログイン済みユーザーのマイリストを取得
                $query = Product::whereHas('interactions', function ($query) {
                    $query->where('user_id', Auth::id())
                          ->where('type', 'like');
                });
            }
        } else {
            // 全商品を取得
            $query = Product::query();
        }

        // 検索条件を適用
        if (isset($query) && !empty($searchQuery)) {
            $query->where('name', 'LIKE', "%{$searchQuery}%");
        }

        // 結果を取得
        return isset($query) ? $query->get() : $products;
    }

    /**
     * リダイレクト処理を共通化
     */
    protected function handleRedirects(Request $request)
    {
        if ($request->has('logout')) {
            Auth::logout();
            return redirect()->route('home_route');
        }

        if ($request->has('login') || (!$request->has('logout') && !Auth::check() && ($request->has('mypage') || $request->has('sell')))) {
            return redirect()->route('login.show')->with('message', 'ログインが必要です。');
        }

        if ($request->has('mypage')) {
            return redirect('mypage');
        }

        if ($request->has('sell')) {
            return redirect()->route('sell');
        }

        return null; // リダイレクト不要の場合
    }
}




/*protected function getProducts(Request $request)
    {
        $searchQuery = $request->input('search', ''); // search というパラメータを取得し、もし存在しなければ空文字 '' をデフォルト値として設定する。それによって、リクエストに search が含まれていない場合でもエラーを回避できる。
        $tab = $request->get('tab', 'recommend');    // デフォルトは 'recommend'　リクエストから tab パラメータを取得し、存在しない場合は 'recommend' をデフォルト値とする、
        $products = collect();                       // 空のコレクションを初期値とする　collect() は空のコレクションを作成します。結果が見つからなかった場合などに備え、デフォルトの値として初期化しています。

        // タブ判定に基づくクエリの構築
        if ($tab === 'mylist') {
            if (Auth::check()) {
                // ログイン済みユーザーのマイリストを取得
                $query = Product::whereHas('interactions', function ($query) {
                    $query->where('user_id', Auth::id())
                          ->where('type', 'like');
                });
            }
        } else {
            // 全商品を取得
            $query = Product::query();
        }
            ユーザーがログイン済みかどうかを Auth::check() で確認
            ログイン済みの場合は、Product::whereHas() を使用して、マイリスト（"like" された商品）を取得する。
            whereHas() は、関連モデルの条件に基づいてクエリを絞り込みます。
            Auth::id() で現在のログイン中のユーザーの ID を取得し、user_id が一致し、type が 'like' である商品を絞り込みます。
            それ以外（$tab が 'mylist' ではない場合）
            $query = Product::query(); により、全ての商品のクエリを取得します。
            検索条件を適用する部分
isset($query) は、$query が設定されているか確認します。
さらに !empty($searchQuery) をチェックして、searchQuery が空でない場合に検索条件を追加します。

where('name', 'LIKE', "%{$searchQuery}%") は、name カラムに searchQuery が含まれる商品を絞り込みます。
結果の取得
isset($query) に基づき、クエリが存在すれば $query->get() でデータを取得し、存在しない場合は空のコレクション $products を返します。


        // 検索条件を適用
        if (isset($query) && !empty($searchQuery)) {
            $query->where('name', 'LIKE', "%{$searchQuery}%");
        }

        // 結果を取得
        return isset($query) ? $query->get() : $products;
    }


    handleRedirects メソッドのreturn null;について
    PHP の関数やメソッドは、明示的に return を指定しない場合、null を暗黙的に返す、
    明示的な return null; がなくても動作するが
    コードの可読性が下がり、
    将来的に関数の返り値を検査する場合、戻り値が常に明確である方がバグを防ぎやすくなるため
    必須ではないが付けた方が無難*/