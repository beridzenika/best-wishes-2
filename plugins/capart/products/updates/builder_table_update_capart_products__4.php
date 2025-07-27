<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts4 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->decimal('price_before_sale', 10, 2);
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->dropColumn('price_before_sale');
        });
    }
}
