<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('driver_auto_positioning_events', function (Blueprint $table) {
            $table->id();

            $table->uuid('driver_uuid')->index();
            $table->string('driver_name')->nullable();

            $table->dateTime('repositioning_prompt_timestamp')->nullable();
            $table->string('repositioning_prompt_outcome')->nullable();
            $table->string('navigation_outcome')->nullable();

            $table->decimal('actual_distance_km', 10, 4)->nullable();
            $table->decimal('actual_time_minutes', 10, 4)->nullable();
            $table->decimal('recommended_distance_km', 10, 4)->nullable();

            $table->decimal('source_latitude', 10, 6)->nullable();
            $table->decimal('source_longitude', 10, 6)->nullable();
            $table->decimal('destination_latitude', 10, 6)->nullable();
            $table->decimal('destination_longitude', 10, 6)->nullable();

            $table->dateTime('trip_before_repositioning_timestamp')->nullable();
            $table->uuid('trip_before_repositioning_uuid')->nullable();

            $table->dateTime('next_dispatch_sent_timestamp')->nullable();
            $table->uuid('next_dispatch_sent_uuid')->nullable();

            $table->dateTime('next_dispatch_accepted_timestamp')->nullable();
            $table->uuid('next_dispatch_accepted_trip_uuid')->nullable();

            $table->string('upload_batch_id')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_auto_positioning_events');
    }
};
