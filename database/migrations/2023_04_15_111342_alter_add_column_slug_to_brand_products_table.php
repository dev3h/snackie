<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnSlugToBrandProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table_name = 'brand_products';
    private $column = 'slug';
    public function up()
    {

        if (!Schema::hasColumn($this->table_name, $this->column)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->string($this->column)->after('status');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn($this->table_name, $this->column)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->dropColumn($this->column);
            });
        }
    }
}
