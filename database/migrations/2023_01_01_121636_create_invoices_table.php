<?php

use App\Models\Currency;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id()->startingValue(2000);
            //
            $table->unsignedBigInteger('person_company_id');
            $table->unsignedBigInteger('currency_id')->default(Currency::CURRENCY_EURO);
            $table->unsignedBigInteger('invoice_status_id');
            $table->unsignedBigInteger('invoice_type_id');
            //
            $table->string('invoice_number', 50)->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->double('sum_net_price')->nullable();
            $table->double('sum_value_added_tax')->nullable();
            $table->double('sum_gross_price')->nullable();
            $table->text('history')->nullable();
            $table->text('notes')->nullable();
            //
            $table->date('reminder_date')->nullable();
            $table->date('reminder_due_date')->nullable();
            //
            $table->unsignedBigInteger('correction_invoice_id')->nullable();
            //
            $table->unsignedBigInteger('original_invoice_id')->nullable();
            $table->string('original_invoice_number', 100)->nullable();
            $table->date('original_invoice_date')->nullable();
            //
            $table->string('person_company_number', 100)->nullable();
            //
            $table->integer('contactperson_salutation_id')->default(1);
            $table->string('contactperson_first_name', 100)->nullable();
            $table->string('contactperson_last_name', 100)->nullable();
            //
            $table->string('bankconnection_iban', 35)->nullable();
            $table->string('bankconnection_accountholder', 50)->nullable();
            //
            $table->string('billing_address', 100)->nullable();
            $table->string('billing_address_line_2', 100)->nullable();
            $table->string('billing_street', 100)->nullable();
            $table->integer('billing_country_id')->nullable();
            $table->string('billing_postcode', 20)->nullable();
            $table->string('billing_city', 100)->nullable();
            //
            $table->string('our_company_name', 200)->nullable();
            $table->string('our_address', 400)->nullable();
            //
            $table->string('our_footer_line_1', 200)->nullable();
            $table->string('our_footer_line_2', 200)->nullable();
            $table->string('our_footer_line_3', 200)->nullable();
            $table->string('our_footer_line_4', 200)->nullable();
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
        Schema::dropIfExists('invoices');
    }
};
