<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeColumnInOrdersTable extends Migration
{
    private $table_name = 'orders';
    private $column1 = 'customer_id';
    private $column2 = 'shipping_id';
    private $column3 = 'payment_id';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            if (Schema::hasColumn($this->table_name, $this->column1)) {
                Schema::table($this->table_name, function (Blueprint $table) {
                    $table->unsignedBigInteger($this->column1)->change();
                });
            }
            if (Schema::hasColumn($this->table_name, $this->column2)) {
                Schema::table($this->table_name, function (Blueprint $table) {
                    $table->unsignedBigInteger($this->column2)->change();
                });
            }
            if (Schema::hasColumn($this->table_name, $this->column3)) {
                Schema::table($this->table_name, function (Blueprint $table) {
                    $table->unsignedBigInteger($this->column3)->change();
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
