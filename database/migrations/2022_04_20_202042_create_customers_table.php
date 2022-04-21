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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('mobile');
            $table->string('country');
            $table->string('city');
            $table->string('postal_code');
            $table->string('address');
            $table->unsignedBigInteger('user_id')->unsigned(); 
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('action_id')->unsigned(); 
            $table->foreign('action_id')->references('id')->on('customer_actions');
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
        Schema::dropIfExists('customers');
    }
};
