<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code');
            $table->integer('category_id');
            $table->longtext('details')->nullable();
            $table->double('cost_price');
            $table->double('sales_price');
            $table->integer('initial_stock');
            $table->integer('total_stock');
            $table->string('unit')->nullable();
            $table->integer('user_id');
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('products');
    }
}
