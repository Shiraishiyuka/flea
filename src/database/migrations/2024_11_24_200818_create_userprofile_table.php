<?php

use Illuminate\Database\Migrations\Migration; /*マイグレーションファイルの基本動作に関わる。これがないとマイグレーションができない。*/
use Illuminate\Database\Schema\Blueprint; /*テーブル構造を定義するためのメソッド（例: string, integer, timestamps など）を提供 */
use Illuminate\Support\Facades\Schema; /*テーブル作成や変更（例: Schema::create, Schema::drop）を操作するためのファサード*/
/*上記３つはマイグレーションする際に必須です。*/

class CreateUserprofileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // usersテーブルとリレーション
            /*foreignId('user_id'): 外部キー（user_id カラム）を作成*/
            /*constrained(): 対象の外部キーを、自動的に関連付ける対象テーブル（ここでは users）に紐づける*/
            /*onDelete('cascade'): 親（users テーブル）のレコードが削除された場合、それに関連する user_profiles のレコードも削除する*/
            /*$table->foreignId('user_id');だけだと関連する親データが削除されても、孤立した子データが残る可能性がある。*/
            $table->string('name');
            $table->string('post_code');
            $table->string('address');
            $table->string('building')->nullable();
            $table->string('profile_image_path'); // 画像パスは文字列型、データベースにはパスだけを保存する。
            $table->timestamps();  // 作成日・更新日
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
}
