<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts15 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->dropColumn('sale');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('sale');
        });
    }
}
