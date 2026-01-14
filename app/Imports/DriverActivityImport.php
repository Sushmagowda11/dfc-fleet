<?php

namespace App\Imports;

use App\Models\DriverActivityUpload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DriverActivityImport implements ToModel, WithHeadingRow
{
public function model(array $row)
{
    return new DriverActivityUpload([
        'driver_uuid'     => $row['driver_uuid'] ?? null,
        'first_name'      => $row['driver_first_name'] ?? null,
        'last_name'       => $row['driver_surname'] ?? null,
        'trips_completed' => $row['trips_completed'] ?? 0,

        // correct mapping for long headers
        'time_online' => $row['time_online_days_hours_minutes'] ?? null,
        'time_on_trip' => $row['time_on_trip_days_hours_minutes'] ?? null,

        'upload_batch_id' => now()->format('YmdHis'),
    ]);
}
}
