<?php

use Illuminate\Database\Migrations\Migration; /*メール確認機能 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken(); /*ログイン状態を保持する*/
            $table->timestamps();  // 認証日時を保存するカラム
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

     public function down()
    {
        Schema::dropIfExists('users');
    }
};
