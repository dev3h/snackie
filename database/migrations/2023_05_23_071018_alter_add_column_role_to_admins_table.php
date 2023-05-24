<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnRoleToAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    private $table_name = 'admins';
    private $column = 'role';
    public function up()
    {
        if (!Schema::hasColumn($this->table_name, $this->column)) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->smallInteger($this->column)->after('name')->comment('AdminRoleEnum')->default(0)->index();
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
