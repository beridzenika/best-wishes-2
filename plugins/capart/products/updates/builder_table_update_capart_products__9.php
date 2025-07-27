<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts9 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('quantity')->nullable()->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->dropColumn('quantity');
        });
    }
}
