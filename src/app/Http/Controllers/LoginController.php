<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
       return view('auth.login');
    }

    



    public function verify(LoginRequest $request)
{
    $credentials = $request->only('email', 'password');

    // 認証試行
    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // プロフィールが完了しているかの確認
        if ($user->profile_complete) {
            return redirect('/'); // ホーム画面
        }

        return redirect('/mypage'); // プロフィール設定画面
    }

    // 認証失敗時
    return back()->withErrors(['login' => 'ログイン情報が正しくありません'])
                 ->withInput($request->only('email'));
}
}