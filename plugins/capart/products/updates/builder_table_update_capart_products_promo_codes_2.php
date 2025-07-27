<?php namespace Capart\Products\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartProductsPromoCodes2 extends Migration
{
    public function up()
    {
        Schema::table('capart_products_promo_codes', function($table)
        {
            $table->decimal('discount', 10, 2);
        });
    }
    
    public function down()
    {
        Schema::table('capart_products_promo_codes', function($table)
        {
            $table->dropColumn('discount');
        });
    }
}
