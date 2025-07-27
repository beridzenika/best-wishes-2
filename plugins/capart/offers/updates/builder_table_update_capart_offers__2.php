<?php namespace Capart\Offers\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartOffers2 extends Migration
{
    public function up()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->smallInteger('status_id')->nullable()->default(1)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_offers_', function($table)
        {
            $table->smallInteger('status_id')->nullable(false)->default(null)->change();
        });
    }
}
