<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) 
        {
            $table->id();
            $table->string('surname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->string('cardnumber')->nullable();
            $table->foreignId('payment_mode_id')->nullable();
            $table->foreignId('delivery_mode_id')->nullable();
            $table->foreignId('user_id');
            $table->foreign('payment_mode_id')->references('id')->on('payment_modes');
            $table->foreign('delivery_mode_id')->references('id')->on('delivery_modes');
            $table->foreign('user_id')->references('id')->on('users');
            
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
