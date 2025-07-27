<?php namespace Capart\Offers\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartOffersToProducts extends Migration
{
    public function up()
    {
        Schema::create('capart_offers_to_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('offer_id');
            $table->integer('product_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_offers_to_products');
    }
}
