<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode', 100);
            $table->integer('orders_id')->unsigned();
            $table->integer('cashier_id')->unsigned()->nullable();
            $table->string('bayar', 50)->nullable();
            $table->string('kembalian', 50)->nullable();
            $table->string('discount', 50)->nullable();
            $table->string('pajak', 50)->nullable();
            $table->string('total_harga', 150)->nullable();
            $table->enum('status', ['1', '0', 'x'])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
