<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data', function (Blueprint $table) {
            $table->id('phone');
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->enum('sex', ['Не указан','Мужской', 'Женский'])->default('Не указан');
            $table->enum('type', ['Не указан','Пенсионер', 'Ребёнок', 'Взрослый'])->default('Не указан');
            $table->date('birthday')->nullable();
            $table->string('location')->nullable();
            $table->text('about')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('user_data');
    }
}
