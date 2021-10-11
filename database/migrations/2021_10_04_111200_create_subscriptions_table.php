<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 36)->unique();
            $table->string('external_key', 36);
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->integer('renewals');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('plan_id');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('plan_id')
                ->references('id')
                ->on('plans')
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
        Schema::dropIfExists('subscriptions');
    }
}
