<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ユーザーID onDelete('cascade')によりユーザーが削除された場合に関連する商品のデータも削除される。
            $table->string('name'); // 商品名
            $table->text('description'); // 商品説明
            $table->string('category'); // カラム category は文字列型として作成
            $table->json('category')->change(); // categoryをJSON型に変更 データベースの構造が更新され、JSONとして保存・検索できるようになる
            $table->string('condition'); // 商品状態
            $table->unsignedInteger('price'); // 販売価格
            $table->string('image_path'); // 商品画像のパス
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 外部キー制約を解除する
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        /*外部キーとして product_id が設定されており、外部キー制約を削除しないまま products テーブルを削除しようとするとエラーが発生するため
        先に外部キー制約を解除（dropForeign）。
その後、products テーブルを削除（Schema::dropIfExists('products')）している。*/

        // products テーブルを削除
        Schema::dropIfExists('products');
        /*products テーブルが存在していれば削除する処理*/
    }
}
