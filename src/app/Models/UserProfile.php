<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    /*モデルでファクトリを使用してダミーデータを作成するため */

    protected $fillable = [
        'user_id',
        'name',
        'post_code',
        'address',
        'building',
        'profile_image_path',
    ];

    // リレーション設定
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getProfileImagePathAttribute($value) /*内容: アクセサ（Accessor）を定義*/
{
    return $value ? 'storage/profile_images/' . $value : null;
    /*モデルのプロパティにアクセスしたときの値を自動的に加工*/
    /*動作としては$userProfile->profile_image_path にアクセスすると
    $value にデータベースから取得した値が代入される。
値が存在する場合、storage/profile_images/ を付加。
値が存在しない場合、null を返す。*/
}
}