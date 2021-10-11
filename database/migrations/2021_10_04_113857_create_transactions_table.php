<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 36)->unique();
            $table->string('external_key', 36);
            $table->json('op_response')->nullable();
            $table->string('op_ref_transaction', 191);
            $table->string('ref_transaction', 191);
            $table->enum('type', ['PENDING', 'SUCCESS', 'FAILED', 'CANCELED', 'EXPIRED'])->default('PENDING');
            $table->unsignedBigInteger('invoice_id');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
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
        Schema::dropIfExists('transactions');
    }
}
