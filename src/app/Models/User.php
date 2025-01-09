<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;  
use Laravel\Sanctum\HasApiTokens; 

class User extends Authenticatable
{
    use HasFactory;

    protected $casts = [
    'two_factor_expires_at' => 'datetime',
    ];


    protected $fillable = [
        'name',
        'email',
        'password',
        'auth_token',

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