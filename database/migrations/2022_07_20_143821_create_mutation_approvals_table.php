<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutationApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutation_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mutationId');
            $table->unsignedBigInteger('userId');
            $table->string('status');
            $table->string('comment')->nullable();
            $table->text('signature')->nullable();
            // $table->softDeletes();
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
        Schema::dropIfExists('mutation_approvals');
    }
}
