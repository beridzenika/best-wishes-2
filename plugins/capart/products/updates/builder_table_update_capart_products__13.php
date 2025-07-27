<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts13 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('color_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('color_id')->nullable(false)->change();
        });
    }
}
