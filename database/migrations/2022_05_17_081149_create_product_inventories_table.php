<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('inventaryCode');
            $table->string('productId');
            $table->string('purchasingNumber');
            $table->date('registeredDate');
            $table->date('yearOfEntry');
            $table->date('yearOfUse');
            $table->string('serialNumber');
            $table->date('yearOfEnd');
            $table->string('sertificateNumber');
            $table->string('sertificateMaker');
            $table->string('productOrigin');
            $table->string('productPrice');
            $table->string('productDescription');
            $table->string('productStatus');
            $table->string('inventaryImageUrl');
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
        Schema::dropIfExists('product_inventories');
    }
}
