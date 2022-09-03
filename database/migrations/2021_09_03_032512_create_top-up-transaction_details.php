<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopUpTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_transaction_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('topup_transaction_id');
            $table->string('username');
            $table->string('saldo');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('topup_transaction_details');
    }
}
