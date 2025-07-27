<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProductsPromoCodes extends Migration
{
    public function up()
    {
        Schema::table('capart_products_promo_codes', function($table)
        {
            $table->smallInteger('status_id');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_promo_codes', function($table)
        {
            $table->dropColumn('status_id');
        });
    }
}
