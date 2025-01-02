<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules()
{
    return [
        'name' => 'required|string|max:255', // 必須、文字列、255文字以内
        'email' => 'required|email|unique:users,email', // 必須、正しい形式、users テーブルで一意
        'password' => 'required|string|min:8|confirmed', // 必須、8文字以上、確認と一致
        'password_confirmation' => 'required|string', // 必須、文字列
    ];
}

public function messages()
{
    return [
        'name.required' => '名前を入力してください。',
        'name.string' => '名前は文字列で入力してください。',
        'name.max' => '名前は255文字以内で入力してください。',
        'email.required' => 'メールアドレスを入力してください。',
        'email.email' => 'メールアドレスは「ユーザー名@ドメイン」の形式で入力してください。',
        'email.unique' => 'このメールアドレスは既に登録されています。',
        'password.required' => 'パスワードを入力してください。',
        'password.string' => 'パスワードは文字列で入力してください。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.confirmed' => 'パスワードと一致しません。',
        'password_confirmation.required' => '確認用パスワードを入力してください。',
        'password_confirmation.string' => '確認用パスワードは文字列で入力してください。',
    ];
}
}


/*'email' => 'required|email|unique:users,email', // 必須、正しい形式、users テーブルで一意
指定された値がデータベースに既に存在しないことを確認
新規登録時に、同じメールアドレスが登録されていないか確認する用途に使われる。
構文: unique:<テーブル名>,<カラム名>
users: 対象テーブル。
email: 対象カラム。

exists: 指定された値がテーブルに存在することを確認。
unique: 指定された値がテーブルに存在しないことを確認。

使い分け:
ログイン時: exists:users,email（存在するか確認）
新規登録時: unique:users,email（重複していないか確認）

更新時の重複確認（現在のデータを除外する場合）:
'email' => 'unique:users,email,' . $user->id,

confirmed：
バリデーションルールconfirmedは、入力された値が「対応する確認用フィールド」と一致していることを確認する。
対応するフィールド名は「元のフィールド名 + _confirmation」という名前である必要がある。

例: passwordフィールドの場合、対応する確認フィールドはpassword_confirmation。
'password' => 'required|string|min:8|confirmed',
このルールは以下をチェックします:
passwordが8文字以上。
passwordとpassword_confirmationが一致。

フォーム名
<input type="password" name="password">
<input type="password" name="password_confirmation"> */