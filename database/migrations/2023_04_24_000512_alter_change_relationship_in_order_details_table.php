<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeRelationshipInOrderDetailsTable extends Migration
{
    private $table_name = 'order_details';
    private $column = 'order_id';
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
                    $table->dropColumn('id');
                    $table->primary([$this->column, 'product_id']);
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
        });
    }
}
