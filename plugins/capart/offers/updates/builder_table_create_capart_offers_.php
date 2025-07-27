<?php namespace Capart\Offers\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartOffers extends Migration
{
    public function up()
    {
        Schema::create('capart_offers_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->decimal('price', 10, 2);
            $table->date('end_date');
            $table->smallInteger('status_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_offers_');
    }
}
