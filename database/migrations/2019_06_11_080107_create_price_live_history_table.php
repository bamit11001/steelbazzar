<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceLiveHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_live_history', function (Blueprint $table) {
            // Schema::create('price_live', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('region_id');
                $table->integer('item_id');
                $table->integer('area_id');
                $table->decimal('price', 8, 2);
                $table->string('gst', 50);
                $table->enum('for_ex', ['for', 'ex']);
                $table->string('delievery', 50);
                $table->string('size', 50);
                $table->string('grade', 50);
                $table->string('unit', 50);
                $table->enum('sentments', ['weak', 'moderate','strong']);
                $table->integer('otp');
                $table->boolean('is_active');
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
        Schema::dropIfExists('price_live_history');
    }
}
