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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            //
            $table->unsignedBigInteger('invoice_id');
            //
            $table->date('service_date')->nullable();
            $table->string('service_description', 400)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('quantity_text', 400)->nullable();
            $table->double('net_price')->nullable();
            $table->double('tax_rate')->nullable();
            $table->double('value_added_tax')->nullable();
            $table->double('gross_price')->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
};
