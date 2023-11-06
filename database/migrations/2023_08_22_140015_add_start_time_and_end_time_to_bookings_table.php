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
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('date')->after('facility_id');
            $table->time('start_time')->after('date');
            $table->time('end_time')->after('start_time');
            $table->enum('status', ['booked', 'canceled','completed'])->after('end_time');
            $table->unsignedBigInteger('total_price')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('status');
            $table->dropColumn('total_price');
        });
    }
};
