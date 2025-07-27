<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartProducts extends Migration
{
    public function up()
    {
        Schema::create('capart_products_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('category_id');
            $table->smallInteger('best_seller');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_products_');
    }
}
