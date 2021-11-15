<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('address_id')->unsigned()->index();
            $table->bigInteger('shipping_method_id')->unsigned()->index();

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods');

            $table->string('status')->default('pending');

            $table->integer('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
