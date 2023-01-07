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
        Schema::create('acquisitions', function (Blueprint $table) {
            $table->id();
            //
            $table->string('email', 100)->nullable();
            $table->string('branch', 100)->nullable();
            $table->dateTime('last_action_date')->nullable();
            $table->string('last_action_name', 100)->nullable();
            //
            $table->boolean('running')->nullable()->default(true);
            $table->boolean('successful')->nullable()->default(false);
            //
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('acquisitions');
    }
};
