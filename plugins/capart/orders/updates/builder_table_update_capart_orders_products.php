<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrdersProducts extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_products', function($table)
        {
            $table->integer('order_id');
            $table->string('title', 255);
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_products', function($table)
        {
            $table->dropColumn('order_id');
            $table->dropColumn('title');
        });
    }
}
