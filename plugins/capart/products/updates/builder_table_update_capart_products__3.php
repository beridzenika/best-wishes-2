<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts3 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->decimal('price', 10, 2);
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->dropColumn('price');
        });
    }
}
