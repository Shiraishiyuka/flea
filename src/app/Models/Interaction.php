<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Interaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'type', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class); /*InteractionはUserに属す。（一対多の関係） インタラクションを実行したユーザーを取得する。*/
    }

    public function product()
    {
        return $this->belongsTo(Product::class); /*InteractionはProductにも属す。インタラクションが紐づいている商品を取得できる。*/
    }
}


/*unsignedBigInteger型
unsignedBigIntegerはMySQLのデータ型UNSIGNED BIGINTを表す。
64ビットの符号なし整数型で、負の値を持たず、格納可能な範囲が広い（0 ～ 18,446,744,073,709,551,615）。
主にID（主キーや外部キー）を格納する際に使用され、
unsignedにすることで負の値を防ぎ、主キーや外部キーとしての整合性を保つ*/
/*table->enum('type', ['like', 'comment'])のtypeという名前
名前はわかりやすいものであればなんでもOK */
