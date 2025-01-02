<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            /* 商品データを保存　バリデーションした後保存*/
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categories' => 'required|', // 配列を必須とする
            'condition' => 'required',
            'price' => 'required|integer|min:1',
            'image' => 'required|mimes:jpeg,png,jpg,gif',
        ];
    }

    public function messages()
    {
         return [
        'name.required' => '名前を入力してください。',
        'name.string' => '名前は文字列で入力してください。',
        'name.max' => '名前は255文字以内で入力してください。',
        'description.string' => '商品の説明は文字列で入力してください。',
        'categories.required' => 'カテゴリーを選択してください。',
        'condition.required' => '商品の状態を選択してください。',
        'price.required' => '価格を入力してください。',
        'price.integer' => '価格は整数で入力してください。',
        'price.min' => '価格は1以上を入力してください。',
        'image.required' => '画像をアップロードしてください。',
        'image.mimes' => '画像は jpeg, png, jpg, gif の形式でアップロードしてください。',
    ];
    }
}
