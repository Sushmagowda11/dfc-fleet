<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverFinancialTransaction extends Model
{
    protected $table = 'driver_financial_transactions';

    protected $fillable = [
        'transaction_uuid',
        'driver_uuid',
        'trip_uuid',
        'driver_name',
        'organisation_name',
        'reported_at',
        'summary_amount',
        'earnings_json',
        'trip_balance_json',
        'raw_row_json'
    ];

    protected $casts = [
        'earnings_json' => 'array',
        'trip_balance_json' => 'array',
        'raw_row_json' => 'array',
        'reported_at' => 'datetime'
    ];
}
