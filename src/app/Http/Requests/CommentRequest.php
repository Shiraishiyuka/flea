<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'コメントを入力してください',
            'comment.max' => '最大文字数は255文字までです',
        ];
    }
}











/*<?php

namespace App\Http\Requests;   名前空間を使うことで、クラスがどこに属するかを明確にし、同名のクラスが存在する場合でも、名前空間が異なれば衝突を避を避けられる。

use Illuminate\Foundation\Http\FormRequest;    FormRequestは、Laravelで提供されるリクエスト検証用の基底クラス
                                                このクラスを継承することで、リクエストデータのバリデーションを簡単に実装できる。

class CommentRequest extends FormRequest       FormRequestを継承することで、リクエスト検証機能を持つカスタムリクエストクラスを作成する。
CommentRequestを利用することで、コメント投稿のリクエストに特化したバリデーションを実現する。
{
    /**
     * Determine if the user is authorized to make this request. 「このリクエストを実行する権限がユーザーにあるかどうかを判定します」
     *
     * @return bool PHPDocコメントで、関数やメソッドの戻り値の型を記述するために使用   boolは、戻り値がtrueまたはfalseのブール値であることを意味します。
     *
    public function authorize()   このメソッドは、リクエストを実行する権限があるかどうかを決定  trueなので、常に権限を許可する。
    {
        return true;
    }

    コード例（認証済みユーザーのみ許可する場合）:
    public function authorize()
{
    return auth()->check(); // ユーザーがログインしているか確認
}



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
    public function rules()　　　リクエストに適用するバリデーションルールを定義している。
    {
        return [
            'comment' => 'required|max:255',
        ];
    }

    public function messages()   バリデーションエラー時のカスタムエラーメッセージを定義する。
    {
        return [
            'comment.required' => 'コメントを入力してください',
            'comment.max' => '最大文字数は255文字までです',
        ];
    }
}
*/