<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryPlacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_placements', function (Blueprint $table) {
            $table->id();
            $table->string('placementNumber');
            $table->date('placementDate');
            $table->string('userId');
            $table->string('locationId');
            $table->text('placementDescription');
            $table->enum('placementType', ['NEW', 'MUTATION']);
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
        Schema::dropIfExists('inventory_placements');
    }
}
