<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'condition',
        'price',
        'image_path',
    ];

    protected $casts = [
        'category' => 'array', // JSONとして保存・取得
    ];
    /*モデルで $casts プロパティを使うと、特定のカラムの値を指定したデータ型に自動的に変換できる*/
    /*'category' => 'array' と設定すると
    データベースから取得した際、JSON文字列を配列に自動変換。
    モデルにデータを保存する際、配列をJSON文字列に自動変換。ができる*/

    /* 保存する場合
    $product = new Product();
    $product->category = ['Electronics', 'Smartphones'];
    $product->save();
    // データベースには JSON 文字列: '["Electronics","Smartphones"]' として保存される。

    // 取得する場合
    $product = Product::find(1);
    $categories = $product->category; // ['Electronics', 'Smartphones'] の配列として取得。*/


    // リレーション設定
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    // Address モデルとのリレーション (1対1)
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
