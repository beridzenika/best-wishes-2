<?php namespace Capart\Categories\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartCategories2 extends Migration
{
    public function up()
    {
        Schema::table('capart_categories_', function($table)
        {
            $table->integer('sort_order')->nullable()->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_categories_', function($table)
        {
            $table->integer('sort_order')->nullable(false)->default(null)->change();
        });
    }
}
