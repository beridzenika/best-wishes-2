<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrders8 extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->smallInteger('promo_code')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->smallInteger('promo_code')->nullable(false)->change();
        });
    }
}
