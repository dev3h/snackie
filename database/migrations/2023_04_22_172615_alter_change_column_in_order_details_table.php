<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeColumnInOrderDetailsTable extends Migration
{
    private $table_name = 'order_details';
    private $column1 = 'order_id';
    private $column2 = 'product_id';
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            //
        });
    }
}
