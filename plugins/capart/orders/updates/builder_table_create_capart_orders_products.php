<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartOrdersProducts extends Migration
{
    public function up()
    {
        Schema::create('capart_orders_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id');
            $table->integer('quantity');
            $table->double('price', 10, 2);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_orders_products');
    }
}
