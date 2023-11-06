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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('visitor_id');
            $table->date('visit_date');
            $table->time('arrival_time');
            $table->time('departure_time')->nullable();
            $table->text('purpose');
            $table->enum('status', ['checked_in', 'checked_out']);
            $table->timestamps();

            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('visitor_id')->references('id')->on('visitors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
