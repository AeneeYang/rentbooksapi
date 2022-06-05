<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_phone',10);
            $table->string('book_barcode',30);
            $table->boolean('rent_status')->default(1);
            $table->timestamps();
            $table->foreign('user_phone')->references('phone')->on('users')->onUpdate('cascade');
            $table->foreign('book_barcode')->references('barcode')->on('books')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
