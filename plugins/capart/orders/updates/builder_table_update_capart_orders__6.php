<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrders6 extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->integer('location_id')->nullable()->default(0);
            $table->dropColumn('city');
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->dropColumn('location_id');
            $table->string('city', 191)->nullable();
        });
    }
}
