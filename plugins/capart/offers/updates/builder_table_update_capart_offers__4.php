<?php namespace Capart\Offers\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOffers4 extends Migration
{
    public function up()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->text('description');
            $table->text('how_to_buy');
        });
    }
    
    public function down()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->dropColumn('description');
            $table->dropColumn('how_to_buy');
        });
    }
}
