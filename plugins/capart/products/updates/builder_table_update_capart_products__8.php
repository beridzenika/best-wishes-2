<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProducts8 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->decimal('price', 10, 2)->nullable()->default(0)->change();
            $table->decimal('price_before_sale', 10, 2)->nullable()->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_', function($table)
        {
            $table->decimal('price', 10, 2)->nullable(false)->default(null)->change();
            $table->decimal('price_before_sale', 10, 2)->nullable(false)->default(null)->change();
        });
    }
}
