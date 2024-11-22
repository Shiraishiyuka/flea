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
        'password.confirmed' => 'パスワードが一致しません。',
        'password_confirmation.required' => '確認用パスワードを入力してください。',
        'password_confirmation.string' => '確認用パスワードは文字列で入力してください。',
    ];
}
}
