<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts2 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('category_id')->nullable()->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->integer('category_id')->nullable(false)->default(null)->change();
        });
    }
}
