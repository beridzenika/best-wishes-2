<?php namespace Capart\Menu\Updates;

use Schema;
use Winter\Storm\Database\Updates\Migration;

class BuilderTableUpdateCapartMenu extends Migration
{
    public function up()
    {
        Schema::table('capart_menu_', function($table)
        {
            $table->string('link', 191)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('capart_menu_', function($table)
        {
            $table->smallInteger('link')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
