<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_id');
            $table->text('customer_name');
            $table->text('customer_email');
            $table->unsignedInteger('invoice_type');
            $table->text('carrier_type');
            $table->text('carrier_id');
            $table->text('address');
            $table->text('tax_title');
            $table->text('tax_number');
            $table->dateTime('refunded_at')->nullable();
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
        Schema::dropIfExists('payment_invoices');
    }
}
