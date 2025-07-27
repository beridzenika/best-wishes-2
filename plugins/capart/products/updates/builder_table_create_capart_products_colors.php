<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartProductsColors extends Migration
{
    public function up()
    {
        Schema::create('capart_products_colors', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('color');
            $table->smallInteger('status_id')->nullable()->default(1);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_products_colors');
    }
}
