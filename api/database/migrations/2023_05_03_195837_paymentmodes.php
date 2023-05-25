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
        Schema::create("payment_modes", function (Blueprint $table) 
        {
            $table->id("id");
            $table->string("payment_mode")->unique();
        });

        DB::table("payment_modes")->insert
        ([
            ["payment_mode" => "By Card"],
            ["payment_mode" => "With Cash"]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
