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
        Schema::create("delivery_modes", function (Blueprint $table) 
        {
            $table->id("id");
            $table->string("delivery_mode")->unique();
        });

        DB::table("delivery_modes")->insert
        ([
            ["delivery_mode" => "Outdoor delivery"],
            ["delivery_mode" => "Postal delivery"]
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
