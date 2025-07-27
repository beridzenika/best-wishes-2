<?php namespace Capart\Categories\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartCategories extends Migration
{
    public function up()
    {
        Schema::table('capart_categories_', function($table)
        {
            $table->integer('sort_order');
        });
    }
    
    public function down()
    {
        Schema::table('capart_categories_', function($table)
        {
            $table->dropColumn('sort_order');
        });
    }
}
