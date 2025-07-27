<?php namespace Capart\Offers\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOffers extends Migration
{
    public function up()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->smallInteger('main_page');
        });
    }
    
    public function down()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->dropColumn('main_page');
        });
    }
}
