<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProductsColors2 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_colors', function($table)
        {
            $table->integer('sort_order');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_colors', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
