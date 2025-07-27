<?php namespace Capart\Payments\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartPayments extends Migration
{
    public function up()
    {
        Schema::create('capart_payments_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('payment_hash')->nullable();
            $table->string('payment_order_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('status')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('ip')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_payments_');
    }
}
