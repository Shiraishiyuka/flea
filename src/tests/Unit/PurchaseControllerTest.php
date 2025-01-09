<?php

namespace Tests\Unit;

use Tests\TestCase; // LaravelのTestCaseを使用
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Product;
use App\Models\Address;


class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_purchase_get_route()
    {
        // ユーザーを作成
        $user = User::factory()->create();

        // 商品を作成
        $product = Product::factory()->create();

        // ログインしてルートにアクセス
        $response = $this->actingAs($user)->get(route('purchase', ['id' => $product->id]));

        // ステータスコード200を期待
        $response->assertStatus(200);

        // ビューに正しいデータが渡されているかを確認
        $response->assertViewHas('product', $product);
    }

    /**
     * 購入ページのPOSTルートをテスト.
     */
    public function test_purchase_post_route()
    {
        // ユーザーと商品を作成
        $user = User::factory()->create();
        $product = Product::factory()->create();

        // POSTリクエストを送信
        $response = $this->actingAs($user)->post(route('purchase', ['id' => $product->id]), [
            'payment_method' => 'コンビニ払い'
        ]);

        // リダイレクトを期待
        $response->assertRedirect(route('mypage'));

        // フラッシュメッセージが設定されていることを確認
        $response->assertSessionHas('success', '購入が完了しました');
    }
}
