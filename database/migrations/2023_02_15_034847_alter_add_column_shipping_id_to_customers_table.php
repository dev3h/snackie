<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnShippingIdToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table_name = 'customers';
    private $column = 'shipping_id';
    public function up()
    {
        if (!Schema::hasColumn($this->table_name, $this->column)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->string($this->column)->nullable()->after('phone');
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
