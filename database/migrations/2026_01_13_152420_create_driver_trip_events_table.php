<?php

// database/migrations/xxxx_xx_xx_create_driver_trip_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('driver_trip_events', function (Blueprint $table) {
            $table->id();

            $table->uuid('trip_uuid')->index();
            $table->uuid('driver_uuid')->index();

            $table->string('driver_first_name')->nullable();
            $table->string('driver_surname')->nullable();

            $table->uuid('vehicle_uuid')->nullable();
            $table->string('number_plate')->nullable();
            $table->string('service_type')->nullable();

            $table->timestamp('trip_request_time')->nullable();
            $table->timestamp('trip_dropoff_time')->nullable();

            $table->text('pickup_address')->nullable();
            $table->text('dropoff_address')->nullable();

            $table->decimal('trip_distance', 8, 2)->nullable();
            $table->string('trip_status')->nullable();
            $table->string('product_type')->nullable();

            $table->decimal('final_rider_fare', 10, 2)->nullable();

            // For linking uploads later
            $table->string('upload_batch_id')->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_trip_events');
    }
};
