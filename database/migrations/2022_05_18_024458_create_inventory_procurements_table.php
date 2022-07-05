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
            $table->string('procurementCode');
            $table->string('userId');
            $table->string('supplierId');
            $table->string('procurementTypeId');
            $table->text('procurementDescription');
            $table->text('procurementSignatureUser');
            $table->date('procurementDate');
            $table->string('totalPrice');
            $table->boolean('status')->default(0);
            // $table->boolean('status')->default(0)->change();
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
