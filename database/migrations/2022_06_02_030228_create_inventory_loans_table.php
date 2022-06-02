<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_loans', function (Blueprint $table) {
            $table->id();
            $table->string('loanId');
            $table->date('loanStartDate');
            $table->date('loanEndDate');
            $table->string('loanerUserId');
            $table->string('officerUserId');
            $table->string('status');
            $table->text('loanDescription');
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
        Schema::dropIfExists('inventory_loans');
    }
}
