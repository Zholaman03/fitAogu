<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysInPostUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_user', function (Blueprint $table) {
            // Сначала удаляем существующий внешний ключ
            $table->dropForeign(['user_id']);
            $table->dropForeign(['post_id']);

            // Затем добавляем новые внешние ключи с каскадным удалением
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_user', function (Blueprint $table) {
            // Может потребоваться изменить этот метод, в зависимости от вашей логики отката миграции
            $table->dropForeign(['user_id']);
            $table->dropForeign(['post_id']);
        });
    }
}

