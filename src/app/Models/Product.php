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
        'category' => 'array', 
    ];


    // リレーション設定
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
