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
        Schema::create('parking_unit_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number');
            $table->string('model');
            $table->string('color');
            $table->date('registration_date');
            $table->unsignedBigInteger('parking_unit_id');
            $table->timestamps();

            $table->foreign('parking_unit_id')->references('id')->on('parking_unit')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_unit_vehicles');
    }
};
