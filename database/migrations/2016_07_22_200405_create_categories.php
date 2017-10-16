<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->default('');
        });
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Политика',
            ], [
                'id' => 2,
                'name' => 'Спорт',
            ], [
                'id' => 3,
                'name' => 'Музыка',
            ], [
                'id' => 4,
                'name' => 'Общество',
            ], [
                'id' => 5,
                'name' => 'Жизнь',
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
