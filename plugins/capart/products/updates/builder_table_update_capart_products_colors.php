<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProductsColors extends Migration
{
    public function up()
    {
        Schema::table('capart_products_colors', function($table)
        {
            $table->string('title');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_colors', function($table)
        {
            $table->dropColumn('title');
        });
    }
}
