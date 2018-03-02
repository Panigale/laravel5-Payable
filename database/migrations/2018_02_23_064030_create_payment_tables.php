<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments' ,function(Blueprint $table){
            $table->increments('id');
            $table->uuid('token');
            $table->string('no');
            $table->boolean('has_paid')->defalue(0);
            $table->unsignedInteger('user_id');
            $table->integer('amount');
            $table->string('response')->nullable();
            $table->string('service_no')->nullable();
            $table->unsignedInteger('payment_method_id');
            $table->unsignedInteger('payment_service_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payment_methods' ,function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('payment_service_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payment_services' ,function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
