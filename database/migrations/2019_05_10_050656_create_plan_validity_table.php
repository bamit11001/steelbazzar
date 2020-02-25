<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanValidityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_validity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('validity_name');
            $table->integer('validity')->comment('in months');
            $table->integer('discount');
            $table->string('discount_type');
            $table->integer('max_discount');
            $table->integer('added_by');
            $table->integer('status');
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
        Schema::dropIfExists('plan_validity');
    }
}
