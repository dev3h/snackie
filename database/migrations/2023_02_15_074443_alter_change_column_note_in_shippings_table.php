<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeColumnNoteInShippingsTable extends Migration
{
    private $table_name = 'shippings';
    private $column = 'note';
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
                    $table->string($this->column)->nullable()->change();
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
        Schema::table('shippings', function (Blueprint $table) {
            //
        });
    }
}
