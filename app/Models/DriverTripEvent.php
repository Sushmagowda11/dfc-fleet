<?php

// app/Models/DriverTripEvent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverTripEvent extends Model
{
    protected $table = 'driver_trip_events';

    protected $fillable = [
        'trip_uuid',
        'driver_uuid',
        'driver_first_name',
        'driver_surname',
        'vehicle_uuid',
        'number_plate',
        'service_type',
        'trip_request_time',
        'trip_dropoff_time',
        'pickup_address',
        'dropoff_address',
        'trip_distance',
        'trip_status',
        'product_type',
        'final_rider_fare',
        'upload_batch_id',
    ];
}
