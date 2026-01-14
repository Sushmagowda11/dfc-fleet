<?php

namespace App\Imports;

use App\Models\DriverAutoPositioningEvent;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DriverAutoPositioningImport implements ToModel, WithHeadingRow
{
    protected string $batchId;

    public function __construct(string $batchId)
    {
        $this->batchId = $batchId;
    }

    /**
     * Handles:
     * - Excel numeric timestamps
     * - String timestamps (31-12-2025 20:33)
     */
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Excel numeric datetime
        if (is_numeric($value)) {
            return Carbon::instance(
                Date::excelToDateTimeObject($value)
            );
        }

        // String datetime
        try {
            return Carbon::parse($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function model(array $row)
    {
        return new DriverAutoPositioningEvent([
            'driver_uuid' => $row['driver_uuid'] ?? null,
            'driver_name' => $row['driver_name'] ?? null,

            'repositioning_prompt_timestamp' =>
                $this->parseDate($row['repositioning_prompt_timestamp'] ?? null),

            'repositioning_prompt_outcome' =>
                $row['repositioning_prompt_outcome'] ?? null,

            'navigation_outcome' =>
                $row['navigation_outcome'] ?? null,

            // ✅ FIXED HEADER KEYS (NO BRACKETS)
            'actual_distance_km' =>
                $row['actual_distance_travelled_km'] ?? null,

            'actual_time_minutes' =>
                $row['actual_time_travelled_min'] ?? null,

            'recommended_distance_km' =>
                $row['recommended_navigation_distance_km'] ?? null,

            'source_latitude' =>
                $row['source_latitude'] ?? null,

            'source_longitude' =>
                $row['source_longitude'] ?? null,

            'destination_latitude' =>
                $row['destination_latitude'] ?? null,

            'destination_longitude' =>
                $row['destination_longitude'] ?? null,

            'trip_before_repositioning_timestamp' =>
                $this->parseDate($row['trip_before_repositioning_timestamp'] ?? null),

            'trip_before_repositioning_uuid' =>
                $row['trip_before_repositioning_uuid'] ?? null,

            'next_dispatch_sent_timestamp' =>
                $this->parseDate($row['next_dispatch_sent_timestamp'] ?? null),

            'next_dispatch_sent_uuid' =>
                $row['next_dispatch_send_uuid'] ?? null,

            'next_dispatch_accepted_timestamp' =>
                $this->parseDate($row['next_dispatch_accepted_timestamp'] ?? null),

            'next_dispatch_accepted_trip_uuid' =>
                $row['next_dispatch_accepted_trip_uuid'] ?? null,

            'upload_batch_id' => $this->batchId,
        ]);
    }
}
