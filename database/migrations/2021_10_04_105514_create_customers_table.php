<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 36)->unique();
            $table->string('external_key', 36);
            $table->string('name', 191);
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('currency');
            $table->string('postal_code')->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->unsignedBigInteger('tenant_id');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
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
        Schema::dropIfExists('customers');
    }
}
