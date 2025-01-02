<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory; /*ファクトリ機能*/
use Illuminate\Foundation\Auth\User as Authenticatable; /*ユーザー認証に必要 */
use Illuminate\Notifications\Notifiable;  /*メール通知を利用する際に必要 */
use Laravel\Sanctum\HasApiTokens; /*Laravel Sanctum を使用した API 認証に必要*/

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'auth_token', // 新しいカラムを追加

    ];

    // リレーション設定
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function products()
{
    return $this->hasMany(Product::class);
}

 // Address リレーション
    public function addresses()
{
    return $this->hasMany(Address::class);
}

    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('auth_token')->nullable()->after('password');
    });
}



public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('auth_token');
    });
}



}