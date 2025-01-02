<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest
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
        'name' => 'required|string|max:255',
        'post_code' => 'required|string|max:10',
        'address' => 'required|string|max:255',
        'building' => 'nullable|string|max:255',
        'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
        'name.required' => '名前を入力してください',
        'name.string' => '名前は文字列で入力してください',
        'name.max' => '名前は最大255文字までです',
        'post_code.required' => '郵便番号を入力してください',
        'post_code.string' => '郵便番号は文字列で入力してください',
        'post_code.max' => '郵便番号は最大10文字までです',
        'address.required' => '住所を入力してください',
        'address.string' => '住所は文字列で入力してください',
        'address.max' => '住所は最大255文字までです',
        'building.string' => '建物名は文字列で入力してください',
        'building.max' => '建物名は最大255文字までです',
        'profile_image.required' => 'プロフィール画像をアップロードしてください',
        'profile_image.image' => '有効な画像ファイルを選択してください',
        'profile_image.mimes' => '画像はjpeg, png, jpg, gif形式のみ許可されています',
        'profile_image.max' => '画像ファイルは最大2MBまでです',
    ];
    }


}


/*型の違いによって、maxやminの挙動が異なる
stringの時のmax:255 文字列型として扱うため。必然的に255は文字列の長さ＝255文字以下になる。
integerの時のmin:1　整数型として扱うため、必然的に１は数値として捉えられるため。　１以上になる。
*/


/*
mimes:jpeg,png,jpg,gifの仕組み
MINE=
ファイルのMIMESタイプを検証するバリデーションルール
MIMEタイプとは、ファイルの種類を識別するためのインターネット標準規格で、ブラウザやサーバーがファイルの形式を判別するのに使う。
上記の場合だと
image: 画像ファイルであることを検証。
mimes: 指定された拡張子（jpeg, png, jpg, gif）のいずれかであることを確認。
max:2048: ファイルサイズが2MB以内であることを検証。
になる。

imageバリデーション

必須ではないが、imageルールを指定すると、アップロードされたファイルが画像ファイル（GIF, PNG, JPEGなど）であるかを確認できる。

必須ではないが、アップロード可能なファイルサイズを制限できる。
サイズの単位はキロバイト（2048KB = 2MB）。
サーバーのストレージやセキュリティの観点から、上限サイズを設定することが推奨される。
*/