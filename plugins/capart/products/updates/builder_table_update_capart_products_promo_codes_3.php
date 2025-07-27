<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProductsPromoCodes3 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_promo_codes', function($table)
        {
            $table->smallInteger('discount_type');
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_promo_codes', function($table)
        {
            $table->dropColumn('discount_type');
        });
    }
}
