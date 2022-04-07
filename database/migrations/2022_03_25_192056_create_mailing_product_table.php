<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_product', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedInteger('mailing_id');
            $table->foreign('mailing_id')->references('id')->on('mailings');

            // $table->unsignedInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('products');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mailing_product');
    }
}
