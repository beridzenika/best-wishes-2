<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->smallInteger('new_arrival');
            $table->smallInteger('hot_sale');
            $table->smallInteger('status_id');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->dropColumn('new_arrival');
            $table->dropColumn('hot_sale');
            $table->dropColumn('status_id');
        });
    }
}
