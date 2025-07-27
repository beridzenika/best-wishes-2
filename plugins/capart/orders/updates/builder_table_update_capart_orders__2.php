<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrders2 extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->double('price', 10, 2)->nullable();
            $table->double('delivery_price', 10, 2)->nullable();
            $table->double('total_price', 10, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->dropColumn('price');
            $table->dropColumn('delivery_price');
            $table->dropColumn('total_price');
        });
    }
}
