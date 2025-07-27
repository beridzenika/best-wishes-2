<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts7 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->text('how_to_buy');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->dropColumn('how_to_buy');
        });
    }
}
