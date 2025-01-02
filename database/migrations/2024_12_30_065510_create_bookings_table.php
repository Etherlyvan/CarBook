<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->string('requested_by');
            $table->foreignId('approver_level_1')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status_level_1')->default('pending'); // Status Level 1
            $table->foreignId('approver_level_2')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status_level_2')->default('pending'); // Status Level 2
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
