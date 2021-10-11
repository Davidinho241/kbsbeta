<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('duration')->nullable();
            $table->json('price');
            $table->string('billing_period', 191);
            $table->enum('type', ['TRIAL', 'EVERGREEN', 'ONETIME'])->default('ONETIME');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
