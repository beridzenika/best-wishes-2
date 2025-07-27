<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrders4 extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->smallInteger('status_id')->nullable()->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->smallInteger('status_id')->nullable(false)->default(null)->change();
        });
    }
}
