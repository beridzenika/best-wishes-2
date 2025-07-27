<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts5 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->string('colour');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->dropColumn('colour');
        });
    }
}
