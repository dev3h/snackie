<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table_name = 'admins';
    private $column1 = 'displayname';
    private $column2 = 'status';
    public function up()
    {
        if (!Schema::hasColumn($this->table_name, $this->column1)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->string($this->column1)->after('username');
            });
        }
        if (!Schema::hasColumn($this->table_name, $this->column2)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->boolean($this->column2)->after('password')->default(1);
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
        if (Schema::hasColumn($this->table_name, $this->column1)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->dropColumn($this->column1);
            });
        }
        if (Schema::hasColumn($this->table_name, $this->column2)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->dropColumn($this->column2);
            });
        }

    }
}
