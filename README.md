# flea（フリマアプリ）

環境構築
Dockerビルド

１git clone git@github.com:estra-inc/confirmation-test-contact-form.git
２DockerDesktopアプリを立ち上げる
３docker-compose up -d --build

Laravel環境構築

１docker-compose exec php bash
２composer install
３「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
４.envに以下の環境変数を追加

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

５アプリケーションキーの作成
php artisan key:generate
６マイグレーションの実行
php artisan migrate
７シーディングの実行
php artisan db:seed


使用技術(実行環境)
PHP8.3.0
Laravel8.83.27
MySQL8.0.26


URL
開発環境：http://localhost/
phpMyAdmin:：http://localhost:8080/
