<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('pelayan_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('koki_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->dropForeign('orders_pelayan_id_foreign');
            $table->dropForeign('orders_koki_id_foreign');
        });
    }
}
