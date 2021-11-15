<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW product_stock_view AS
            SELECT
                products.id AS product_id,
                COALESCE(SUM(stocks.quantity) - COALESCE(SUM(product_order.quantity), 0), 0) AS stock,
                case when COALESCE(SUM(stocks.quantity) - COALESCE(SUM(product_order.quantity), 0), 0) > 0
                    then true
                    else false
                end in_stock
            FROM products
            LEFT JOIN (
                SELECT
                    stocks.product_id AS id,
                    SUM(stocks.quantity) AS quantity
                FROM stocks
                GROUP BY stocks.product_id
            ) AS stocks USING (id)
            LEFT JOIN (
                SELECT
                        product_order.product_id AS id,
                        SUM(product_order.quantity) AS quantity
                    FROM product_order
                    GROUP BY product_order.product_id
            ) AS product_order USING (id)

            GROUP BY products.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS product_stock_view");
    }
}
