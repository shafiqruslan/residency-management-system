<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parking_unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parking_id');
            $table->unsignedBigInteger('unit_id');
            $table->timestamps();
            $table->foreign('parking_id')->references('id')->on('parkings');
            $table->foreign('unit_id')->references('id')->on('units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_unit');
    }
};
