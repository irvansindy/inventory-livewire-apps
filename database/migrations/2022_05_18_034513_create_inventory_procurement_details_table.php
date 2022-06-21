<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryProcurementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_procurement_details', function (Blueprint $table) {
            $table->id();
            $table->string('procurementId');
            $table->string('productId');
            $table->string('description');
            $table->string('quantity');
            $table->string('unitPrice');
            $table->string('imageUrl');
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
        Schema::dropIfExists('inventory_procurement_details');
    }
}
