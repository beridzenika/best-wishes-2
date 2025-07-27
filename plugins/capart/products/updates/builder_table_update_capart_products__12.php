<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts12 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('sort_order')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('sort_order')->nullable(false)->change();
        });
    }
}
