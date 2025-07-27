<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOrders7 extends Migration
{
    public function up()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->decimal('promo_code_discount', 10, 0);
            $table->smallInteger('promo_code');
        });
    }
    
    public function down()
    {
        Schema::table('capart_orders_', function($table)
        {
            $table->dropColumn('promo_code_discount');
            $table->dropColumn('promo_code');
        });
    }
}
