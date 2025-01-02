<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', /* ユーザーID（この住所がどのユーザーに紐づいているかを示す外部キー）。*/
        'post_code',
        'address',
        'building',
        'payment_method',
        'product_id', // 紐づく商品のID（外部キー）
    ];

    // リレーション: Address は User に属する
    public function user()
    {
        return $this->belongsTo(User::class);
    } /*AddressモデルはUserモデルに属し、一対一または多対一の関係*/

     // Product モデルとのリレーション (1対1)
    public function product()
    {
        return $this->belongsTo(Product::class);
    } /*AddressモデルはProductモデルにも属す*/
}
