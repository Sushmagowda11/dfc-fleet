<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverActivityUpload extends Model
{
    protected $fillable = [
    'driver_uuid',
    'first_name',
    'last_name',
    'trips_completed',
    'time_online',
    'time_on_trip',
    'upload_batch_id'
];

}
