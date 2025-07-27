<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts11 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('sort_order')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('sort_order')->default(null)->change();
        });
    }
}
