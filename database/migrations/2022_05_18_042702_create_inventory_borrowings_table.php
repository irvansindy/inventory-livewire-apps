<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryBorrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('borrowId');
            $table->date('borrowStartDate');
            $table->date('borrowEndDate');
            $table->string('borrowerUserId');
            $table->string('officerUserId');
            $table->string('status');
            $table->text('descriptionBorrow');
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
        Schema::dropIfExists('inventory_borrowings');
    }
}
