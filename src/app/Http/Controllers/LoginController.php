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
use App\Mail\TwoFactorCode;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 入力のバリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // 認証を試みる
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'login_error' => 'ログイン情報が登録されていません',
            ])->withInput($request->only('email'));
        }

        $user = Auth::user();

    // 二段階認証トークン生成
        $token = Str::random(60);
        $user->two_factor_token = $token;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        // 二段階認証メール送信
        Mail::to($user->email)->send(new TwoFactorCode(null, $token));

        return back()->with('status', '認証メールが送信されました。メール内のリンクをクリックしてください。');
    }



    public function verifyTwoFactorLink($token)
    {
        $user = User::where('two_factor_token', $token)->first();

        // トークンの有効性を確認
        if (!$user || $user->two_factor_expires_at->isPast()) {
            return redirect()->route('login.show')->withErrors([
                'two_factor' => '認証リンクが無効または期限切れです。',
            ]);
        }

        // トークン情報をクリア
        $user->two_factor_token = null;
        $user->two_factor_expires_at = null;
        $user->save();

        // ユーザーをログイン状態に設定
        Auth::login($user);

        // 初回ログインのチェック
        if (!$user->userProfile()->exists()) {
            return redirect()->route('profile_setting')->with('status', '初回ログインです。プロフィールを設定してください。');
        }

        // 通常ログイン時のリダイレクト
        return redirect('/')->with('status', 'ログインしました');
    }

}