<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sales_id');
            $table->string('invoice_no');
            $table->integer('return_units');
            $table->double('return_amount');
            $table->integer('returned_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('return_transactions');
    }
}
