<?php

// app/Imports/DriverTripImport.php

namespace App\Imports;

use App\Models\DriverTripEvent;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DriverTripImport implements ToModel, WithHeadingRow
{
    protected string $batchId;

    public function __construct(string $batchId)
    {
        $this->batchId = $batchId;
    }

    private function parseDate($value)
    {
        if (empty($value)) return null;

        if (is_numeric($value)) {
            return Carbon::instance(Date::excelToDateTimeObject($value));
        }

        return Carbon::parse($value);
    }

   public function model(array $row)
{
        // dd(array_keys($row));

return new DriverTripEvent([
    'trip_uuid' => $row['trip_uuid'] ?? null,
    'driver_uuid' => $row['driver_uuid'] ?? null,
    'driver_first_name' => $row['driver_first_name'] ?? null,
    'driver_surname' => $row['driver_surname'] ?? null,
    'vehicle_uuid' => $row['vehicle_uuid'] ?? null,
    'number_plate' => $row['number_plate'] ?? null,
    'service_type' => $row['service_type'] ?? null,

    'trip_request_time' =>
        $this->parseDate($row['trip_request_time'] ?? null),

    // ✅ FIXED KEYS
    'trip_dropoff_time' =>
        $this->parseDate($row['trip_drop_off_time'] ?? null),

    'pickup_address' =>
        $row['pick_up_address'] ?? null,

    'dropoff_address' =>
        $row['drop_off_address'] ?? null,

    'trip_distance' => $row['trip_distance'] ?? null,
    'trip_status' => $row['trip_status'] ?? null,
    'product_type' => $row['product_type'] ?? null,
    'final_rider_fare' => $row['final_rider_fare'] ?? null,

    'upload_batch_id' => $this->batchId,
]);
}
}

