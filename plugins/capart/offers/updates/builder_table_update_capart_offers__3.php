<?php namespace Capart\Offers\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOffers3 extends Migration
{
    public function up()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->decimal('old_price', 10, 2)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->dropColumn('old_price');
        });
    }
}
