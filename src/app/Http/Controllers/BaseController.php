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
        $searchQuery = $request->input('search', '');
        $tab = $request->get('tab', 'recommend');

    if ($tab === 'recommend' || $tab === 'mylist') {
        session(['searchQuery' => $searchQuery]);
    }

    $products = collect();

    if ($tab === 'mylist' && Auth::check()) {
        $query = Product::whereHas('interactions', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('type', 'like');
        });
        } else {
            $query = Product::query();
        }

        if (isset($query) && !empty($searchQuery)) {
            $query->where('name', 'LIKE', "%{$searchQuery}%");
        }

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
        return redirect('mypage')->withQuery(['search' => $request->input('search', '')]); // クエリを保持
        }

    if ($request->has('sell')) {
        return redirect()->route('sell')->withQuery(['search' => $request->input('search', '')]); // クエリを保持
    }

    return null;
    }
}
