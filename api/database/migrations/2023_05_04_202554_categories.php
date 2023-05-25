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
        Schema::create("categories", function (Blueprint $table) {
            $table->id("id");
            $table->string("category");
        });

        DB::table("categories")->insert
        ([
            ["category" => "Chicken Egg"],
            ["category" => "Ostrich Egg"],
            ["category" => "Goose Egg"],
            ["category" => "Test Egg"],
            ["category" => "Random Egg"]
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
