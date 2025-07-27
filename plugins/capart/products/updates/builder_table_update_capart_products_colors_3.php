<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProductsColors3 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_colors', function($table)
        {
            $table->integer('sort_order')->nullable()->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_colors', function($table)
        {
            $table->integer('sort_order')->nullable(false)->default(null)->change();
        });
    }
}
