<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcutsionUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_user_data', function (Blueprint $table) {
            $table->foreignId('user_data_phone')->nullable()
                ->references('phone')->on('user_data')
                ->onDelete('CASCADE');
            $table->foreignId('excursion_id')->nullable()
                ->references('id')->on('excursions')
                ->onDelete('CASCADE');
            $table->smallInteger('final_price')->default(0);
            $table->tinyInteger('number_people')->default(0);
            $table->boolean('paid')->default(false);
            $table->timestamp('date_recording')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excutsion_user_data');
    }
}
