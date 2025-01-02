<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ユーザーごとに1つの住所
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('post_code', 10)->nullable();; // 郵便番号
            $table->string('address', 255)->nullable();; // 住所
            $table->string('building', 255)->nullable(); // 建物名（オプション）
            $table->enum('payment_method', ['コンビニ払い', 'カード払い']); // 支払い方法をenum型で設定
            $table->timestamps();

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}










/*<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /*public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ユーザーごとに1つの住所
            /*user_idカラムはunsignedBigInteger型で定義され、ユーザーIDを保存*/
            /*unsignedBigIntegerはMySQLでUNSIGNED BIGINT型として保存
            これは負の値を持たない大きな整数を格納する型
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            /*product_idはproductsテーブルのidを参照する外部キー
            ユーザーに紐づいた住所が特定の商品と関連付けられる仕組み*/
            /*user_idでは外部キー制約を手動で定義していますが、product_idではconstrained()による自動制約を利用している。
            違いは定義方法だけで、リレーションの性質そのものには違いはない。
            $table->string('post_code', 10)->nullable();; // 郵便番号
            /*日本の郵便番号は「123-4567」形式（8文字）ですが、10文字にしている理由は将来的な仕様変更や入力ミス（例: 半角スペース）を許容するため
            string型は文字列全般を許容するため、数字以外でもエラーにならない。
            下記のように。バリデーションをコントローラで設定し、郵便番号の形式をチェックするといい。
            'post_code' => 'required|regex:/^\d{3}-\d{4}$/',

            $table->string('address', 255)->nullable();; // 住所
            $table->string('building', 255)->nullable(); // 建物名（オプション）
            $table->enum('payment_method', ['コンビニ払い', 'カード払い']); // 支払い方法をenum型で設定 enum型は事前に定義された文字列のリストから1つを選択する仕組み
            $table->timestamps();

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            /*foreign: 外部キーを設定
            references: 参照するテーブルのカラムを指定（この場合、usersテーブルのid）
            onDelete('cascade'): 親テーブル（users）のデータが削除された場合に、関連する子テーブル（addresses）のデータも削除される。
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}*/

