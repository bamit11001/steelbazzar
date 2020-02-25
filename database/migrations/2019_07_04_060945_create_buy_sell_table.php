<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuySellTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_sell', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('post_type', ['buy', 'sell']);
            $table->string('item_name', 50);
            $table->integer('weight');
            $table->enum('unit', ['kg', 'mt']);
            $table->decimal('price', 8, 2);
            $table->integer('amount');
            $table->string('name', 50);
            $table->integer('contact_no');
            $table->string('address');
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->integer('added_by');
            $table->boolean('status');
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
        Schema::dropIfExists('buy_sell');
    }
}
