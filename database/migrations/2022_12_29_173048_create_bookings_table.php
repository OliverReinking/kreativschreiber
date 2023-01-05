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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger('person_company_id');
            $table->unsignedBigInteger('booking_type_id');
            $table->unsignedBigInteger('content_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            //
            $table->dateTime('booking_date');
            $table->integer('points');
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
        Schema::dropIfExists('bookings');
    }
};
