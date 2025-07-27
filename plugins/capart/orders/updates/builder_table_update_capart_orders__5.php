<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrders5 extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->dropColumn('payment_order_id');
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->integer('payment_order_id')->nullable();
        });
    }
}
