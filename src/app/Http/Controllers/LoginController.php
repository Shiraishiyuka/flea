<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserProfile;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\UserProfileController;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

      public function login(loginRequest $request)
    {
        // 入力のバリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // 認証を試みる
        if (!Auth::attempt($credentials)) {
            // 認証失敗時にカスタムエラーメッセージを返す
            return back()->withErrors([
                'login_error' => 'ログイン情報が登録されていません',
            ])->withInput($request->only('email'));
        }

        // 認証処理
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // UserProfileが存在するかを確認
            if ($user->userProfile()->exists()) {
                // 両方のテーブルに情報がある場合（2回目以降のログイン）
                return redirect('/')->with('status', 'ログインしました');
            } else {
                // user_profilesに情報がない場合（初回ログイン）
                return redirect()->route('profile_setting')->with('status', '初回ログインです。プロフィールを設定してください。');
            }
        }

        // 認証失敗時の処理
        return back()->withErrors([
            'email' => '認証に失敗しました。正しい情報を入力してください。',
        ]);
    }

}



/*
$credentials = $request->only('email', 'password');
リクエストから特定のキー（email と password）のみを抽出するメソッド。
例えば、フォームに他の入力項目（例: remember_token）があっても、ここでは email と password のみを取り出す。

セキュリティのため：
必要なデータだけを抽出し、不必要なデータが含まれるリクエスト全体をそのまま使うリスクを避ける。
簡潔な認証処理：
$credentials をそのまま認証に渡すため、コードが読みやすくなる。



// 認証を試みる
        if (!Auth::attempt($credentials)) {
            // 認証失敗時にカスタムエラーメッセージを返す
            return back()->withErrors([
                'login_error' => 'ログイン情報が登録されていません',
            ])->withInput($request->only('email'));
        }

        Auth::attempt は、データベースに対して、指定した email と password を用いた認証を試みる。
        password は平文でデータベースに送られない。

        email に一致するユーザーを取得:
users テーブルで email に一致するレコードを取得
password の照合:
ユーザーの password フィールド（暗号化されたパスワード）と、入力されたパスワード（bcrypt で暗号化された値）を比較する。


認証成功の場合：ログインが実行され、true を返します。
認証失敗の場合：false を返します。
戻り値

成功時: true を返し、ユーザーを認証状態にします。
失敗時: false を返します。


2回目の Auth::attempt の必要性について
1回目：
if (!Auth::attempt($credentials)) {
    // 認証失敗時の処理
}
認証の成否に応じてエラーメッセージを返す。


2回目：
if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    // 認証成功時の分岐処理
}
初回ログインかどうかを判定するために再試行。


*/