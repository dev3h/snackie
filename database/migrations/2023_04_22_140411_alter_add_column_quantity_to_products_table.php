<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnQuantityToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table_name = 'products';
    private $column = 'quantity';
    public function up()
    {
        if (!Schema::hasColumn($this->table_name, $this->column)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->integer($this->column)->default(0)->after('name');
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
