<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->integer('purchase_id')->nullable();
            $table->integer('sales_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->double('amount')->nullable()->default(0);
            $table->string('method');
            $table->string('type')->nullable();
            $table->string('note')->nullable();
            $table->enum('payment_status', ['paid', 'not paid'])->nullable();
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
        Schema::dropIfExists('payments');
    }
}
