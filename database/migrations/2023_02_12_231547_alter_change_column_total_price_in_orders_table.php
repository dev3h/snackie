<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeColumnTotalPriceInOrdersTable extends Migration
{
    private $table_name = 'orders';
    private $column = 'total_price';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            if (Schema::hasColumn($this->table_name, $this->column)) {
                Schema::table($this->table_name, function (Blueprint $table) {
                    $table->text($this->column)->change();
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
