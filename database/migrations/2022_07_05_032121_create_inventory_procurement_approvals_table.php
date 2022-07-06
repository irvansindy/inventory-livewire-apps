<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryProcurementApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_procurement_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('procurementId');
            $table->unsignedBigInteger('userId');
            $table->string('status');
            $table->string('comment')->nullable();
            $table->text('signature')->nullable();
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
        Schema::dropIfExists('inventory_procurement_approvals');
    }
}
