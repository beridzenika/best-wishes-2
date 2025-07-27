<?php namespace Capart\Orders\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableCreateCapartOrders extends Migration
{
    public function up()
    {
        Schema::create('capart_orders_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('payment_order_id');
            $table->smallInteger('status_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('city')->nullable();
            $table->string('id_number')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('second_phone_number')->nullable();
            $table->text('comment')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('capart_orders_');
    }
}
