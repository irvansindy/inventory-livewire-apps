<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryProcurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_procurements', function (Blueprint $table) {
            $table->id();
            $table->string('procurmentCode');
            $table->string('userId');
            $table->string('productId');
            $table->string('supplierId');
            $table->string('procurementTypeId');
            $table->text('descriptionProcurement');
            $table->string('totalPrice');
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
        Schema::dropIfExists('inventory_procurements');
    }
}
