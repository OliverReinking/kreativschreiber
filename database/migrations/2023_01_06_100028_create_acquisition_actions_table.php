<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acquisition_actions', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger('acquisition_id');
            //
            $table->dateTime('action_date')->nullable();
            $table->string('action_name', 100)->nullable();
            //
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
        Schema::dropIfExists('acquisition_actions');
    }
};
