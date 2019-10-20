<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->date('date');
            $table->string('invoice_no');
            $table->integer('sales_id')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->string('transaction_type');
            $table->double('total');
            $table->double('paid');
            $table->float('change_amount')->nullable();
            $table->boolean('return')->default(0);
            $table->boolean('pos')->default(0);
            $table->double('net_total')->nullable();
            $table->double('total_cost_price')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
