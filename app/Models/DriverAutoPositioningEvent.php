<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverAutoPositioningEvent extends Model
{
    protected $table = 'driver_auto_positioning_events';

    protected $fillable = [
        'driver_uuid',
        'driver_name',
        'repositioning_prompt_timestamp',
        'repositioning_prompt_outcome',
        'navigation_outcome',
        'actual_distance_km',
        'actual_time_minutes',
        'recommended_distance_km',
        'source_latitude',
        'source_longitude',
        'destination_latitude',
        'destination_longitude',
        'trip_before_repositioning_timestamp',
        'trip_before_repositioning_uuid',
        'next_dispatch_sent_timestamp',
        'next_dispatch_sent_uuid',
        'next_dispatch_accepted_timestamp',
        'next_dispatch_accepted_trip_uuid',
        'upload_batch_id',
    ];
}
