<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeColumnInProductsTable extends Migration
{
    private $table_name = 'products';
    private $column1 = 'category_id';
    private $column2 = 'brand_id';
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
        Schema::table('products', function (Blueprint $table) {
        });
    }
}
