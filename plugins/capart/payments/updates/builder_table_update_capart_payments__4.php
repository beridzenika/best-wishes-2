<?php namespace Capart\Payments\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartPayments4 extends Migration
{
    public function up()
    {
        Schema::table('capart_payments_', function($table)
        {
            $table->renameColumn('refuse_reason', 'reject_reason');
        });
    }
    
    public function down()
    {
        Schema::table('capart_payments_', function($table)
        {
            $table->renameColumn('reject_reason', 'refuse_reason');
        });
    }
}
