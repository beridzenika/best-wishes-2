<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrders9 extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->decimal('promo_code_discount', 10, 0)->nullable()->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->decimal('promo_code_discount', 10, 0)->nullable(false)->default(null)->change();
        });
    }
}
