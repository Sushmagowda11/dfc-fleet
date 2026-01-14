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
        Schema::create('driver_activity_uploads', function (Blueprint $table) {
    $table->id();
    $table->uuid('driver_uuid');

    $table->string('first_name')->nullable();
    $table->string('last_name')->nullable();

    $table->integer('trips_completed')->default(0);

    $table->string('time_online')->nullable(); // 08:05:40
    $table->string('time_on_trip')->nullable(); // 03:09:11

    $table->string('upload_batch_id')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_activity_uploads');
    }
};
