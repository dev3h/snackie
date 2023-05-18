<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChangeColumnStatusInPaymentTable extends Migration
{
    private $table_name = 'payments';
    private $column = 'status';
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
                    $table->smallInteger($this->column)->comment('PaymentStatusEnum')->default(0)->change();
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
        Schema::table('payment', function (Blueprint $table) {
            //
        });
    }
}
