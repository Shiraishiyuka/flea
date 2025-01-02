<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); /*ユーザーID（この住所がどのユーザーに紐づいているかを示す外部キー） インタラクションを行ったユーザーのID*/
            $table->unsignedBigInteger('product_id'); /*紐づく商品のID（外部キー） インタラクションの対象となる商品のID*/
            $table->enum('type', ['like', 'comment']); /*type: インタラクションの種類（like または comment）*/
            $table->string('comment',255)->nullable();  /*comment: コメント内容（typeがcommentの場合に利用）*/
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interactions');
    }
}
