<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth; // Auth ファサードを正しくインポート
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function home(Request $request) 
    {
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

        return view('home', compact('products', 'tab', 'searchQuery'));
    }

    public function mylist(Request $request)
    {
        $request->merge(['tab' => 'mylist']);
        return $this->home($request);
    }
}




/*$redirect = $this->handleRedirects($request);
handleRedirects メソッドは、Baseコントローラーに記述しているほかのコントローラーでも使用される共通のメソッド
特定の条件に基づいてリダイレクトを処理するもの
$redirect には、リダイレクトのレスポンスが代入され
もしも必要ない場合は、nullが返される。

if ($redirect) { return $redirect; }

$redirect が null でない（つまりリダイレクトが必要な場合）には、リダイレクトのレスポンスをそのまま返す。
これにより、リクエストを処理せず、ユーザーが別のページに移動できる。
リダイレクトがない場合（$redirect === null）、そのまま次の処理（検索処理やビューの生成）に進む。


 検索処理の仕組み
$products = $this->getProducts($request);

getProducts メソッドは、Baseコントローラーに定義されている検索処理用のメソッドで以下の事を実行する、
tab の内容に応じたクエリの切り替え
tab が 'mylist' の場合、ログイン済みユーザーの「いいね」した商品リストを取得。
それ以外の場合、全商品を対象にクエリを生成。
検索条件の適用
検索クエリ（search パラメータ）が存在する場合、その値をもとに name カラムに対して部分一致検索を適用。

クエリの結果を取得
クエリが設定されていればその結果を返し、設定されていなければ空のコレクションを返す。

*/