<?php namespace Capart\Payments\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartPayments3 extends Migration
{
    public function up()
    {
        Schema::table('capart_payments_', function($table)
        {
            $table->text('refuse_reason')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('capart_payments_', function($table)
        {
            $table->dropColumn('refuse_reason');
        });
    }
}
