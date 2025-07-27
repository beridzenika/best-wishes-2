<?php namespace Capart\Categories\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartCategories extends Migration
{
    public function up()
    {
        Schema::create('capart_categories_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->smallInteger('status_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_categories_');
    }
}
