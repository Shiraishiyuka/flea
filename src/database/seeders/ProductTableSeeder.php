<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::all(); 


        $products = [
            [
            'user_id' => '1',
            'name' => '腕時計',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'category' => 'ファッション',
            'condition' => '良好',
            'price' => '15000',
            'image_path' => 'images/Armani+Mens+Clock.jpg',
            ],
        
        [
            'user_id' => '2',
            'name' => 'HDD',
            'description' => '高速で信頼性の高いハードディスク',
            'category' => '家電',
            'condition' => '目立った傷や汚れなし',
            'price' => '5000',
            'image_path' => 'images/HDD+Hard+Disk.jpg',
        ],

        [
            'user_id' => '3',
            'name' => '玉ねぎ3束',
            'description' => '新鮮な玉ねぎ3束のセット',
            'category' => '食べ物',
            'condition' => 'やや傷や汚れあり',
            'price' => '300',
            'image_path' => 'images/iLoveIMG+d.jpg',
        ],

        [
            'user_id' => '4',
            'name' => '革靴',
            'description' => 'クラシックなデザインの革靴',
            'category' => 'ファッション',
            'condition' => '状態が悪い',
            'price' => '4000',
            'image_path' => 'images/Leather+Shoes+Product+Photo.jpg',
        ],

        [
            'user_id' => '5',
            'name' => 'ノートPC',
            'description' => '高性能なノートパソコン',
            'category' => '家電',
            'condition' => '良好',
            'price' => '45000',
            'image_path' => 'images/Living+Room+Laptop.jpg',
        ],

        [
            'user_id' => '6',
            'name' => 'マイク',
            'description' => '高音質のレコーディング用マイク',
            'category' => '家電',
            'condition' => '目立った傷や汚れなし',
            'price' => '8000',
            'image_path' => 'images/Music+Mic+4632231.jpg',
        ],

        [
            'user_id' => '7',
            'name' => 'ショルダーバッグ',
            'description' => 'おしゃれなショルダーバッグ',
            'category' => 'ファッション',
            'condition' => 'やや傷や汚れあり',
            'price' => '3500',
            'image_path' => 'images/Purse+fashion+pocket.jpg',
        ],

        [
            'user_id' => '8',
            'name' => 'タンブラー',
            'description' => '使いやすいタンブラー',
            'category' => 'キッチン',
            'condition' => '状態が悪い',
            'price' => '500',
            'image_path' => 'images/Tumbler+souvenir.jpg',
        ],

        [
            'user_id' => '9',
            'name' => 'コーヒーミル',
            'description' => '手動のコーヒーミル',
            'category' => 'キッチン',
            'condition' => '良好',
            'price' => '4000',
            'image_path' => 'images/Waitress+with+Coffee+Grinder.jpg',
        ],

        [
            'user_id' => '10',
            'name' => 'メイクセット',
            'description' => '便利なメイクアップセット',
            'category' => 'コスメ',
            'condition' => '目立った傷や汚れなし',
            'price' => '2500',
            'image_path' => 'images/makeup_set.jpg',
        ]

    ];
        DB::table('products')->insert($products);
    }
}
