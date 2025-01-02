<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{

    public function showRegisterForm()
    {
        return view('auth.register'); // 登録フォームを表示
    }


    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('status', '登録が完了しました。ログインしてください。');
    }

}




/*
インポート部分
use Illuminate\Support\Facades\Hash;
役割: パスワードやその他の文字列を暗号化するために使用
具体的用途:
上記コードでは、Hash::make()メソッドを使用して、登録時に入力されたパスワードを暗号化していて
暗号化したパスワードは、データベースに保存するために利用される
暗号化されたパスワードは、もとのパスワードに復号化することなく、安全に保存かのう
後でログイン時には、Hash::check()メソッドを使用して、入力されたパスワードと暗号化済みパスワードを比較し、一致するか確認する。


use Illuminate\Support\Facades\Mail;
役割: メールの送信を行うためのファサード（簡単に操作できる仕組み）
具体的用途:
ユーザー登録時に確認メールやお知らせメールを送信するのに使われることが多い

メール送信の例
Mail::to($user->email)->send(new WelcomeMail($user));
Mail::to()メソッドで送信先を指定し、.send()で送信処理を行います。
上記コードではMailが使用されていませんが、後で実装するメール機能（例: 登録確認メールやパスワードリセットメール）をサポートするためにインポートされています。



User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
の仕組み

データ保存の手順
フォームデータをリクエストで取得:
$request->name, $request->email, $request->passwordでフォームから送られたデータを取得します。

モデルを通じてデータベースに保存:
User::create()を使用して、リクエストデータをusersテーブルに保存します。

暗号化処理:
パスワードはHash::make()で暗号化された状態でデータベースに保存されます。

2. データ保存の裏側
Eloquent ORM:

User::create()はEloquentモデルの一部で、テーブルへの新しいレコードの作成を簡単に行うためのメソッドです。
Userモデルは通常、usersテーブルに関連付けられています。
$fillableプロパティ:

モデル内で、保存可能なカラムを指定する必要があります。
例: Userモデル内に次のような設定が必要です。
protected $fillable = ['name', 'email', 'password'];
この設定により、User::create()で指定したデータが安全に挿入されます。


データ保存の流れ
コードの流れ:
User::create([
    'name' => $request->name, // フォームから送信された名前を保存
    'email' => $request->email, // フォームから送信されたメールアドレスを保存
    'password' => Hash::make($request->password), // 暗号化したパスワードを保存
]);
$request->name: リクエストから名前を取得して、nameカラムに対応する値として保存。
$request->email: リクエストからメールアドレスを取得して、emailカラムに対応する値として保存。
Hash::make($request->password): 入力されたパスワードを暗号化して、passwordカラムに保存。
4. 実際の保存
このコードは、以下のようなSQL文を裏で実行します（例）:
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES ('John Doe', 'john@example.com', '$2y$10$hashed_password', '2024-12-21 12:00:00', '2024-12-21 12:00:00');

*/


