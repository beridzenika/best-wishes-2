<?php namespace Capart\Payments\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartPayments2 extends Migration
{
    public function up()
    {
        Schema::table('capart_payments_', function($table)
        {
            $table->dropColumn('payment_hash');
        });
    }
    
    public function down()
    {
        Schema::table('capart_payments_', function($table)
        {
            $table->string('payment_hash', 191)->nullable();
        });
    }
}
