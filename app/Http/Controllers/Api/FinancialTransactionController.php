<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverFinancialTransaction;
use Illuminate\Support\Facades\Log;

class FinancialTransactionController extends Controller
{
    private function getValue($data, $key)
{
    return isset($data[$key]) && $data[$key] !== ''
        ? (float) $data[$key]
        : 0;
}

    public function upload(Request $request)
    {
        try {

            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            Log::info('Upload API hit');

            $file = $request->file('file');
            $path = $file->getRealPath();

            if (!file_exists($path)) {
                throw new \Exception('File not found');
            }

            $rows = array_map('str_getcsv', file($path));

            if (count($rows) < 2) {
                throw new \Exception('CSV has no data');
            }

            // Normalize header (VERY IMPORTANT)
            $rawHeader = array_shift($rows);
            $header = [];

            foreach ($rawHeader as $h) {
                $header[] = trim(str_replace("\xEF\xBB\xBF", '', $h));
            }

            Log::info('CSV headers', $header);

            $inserted = 0;

            foreach ($rows as $index => $row) {

                if (count($header) !== count($row)) {
                    Log::error('Header mismatch', [
                        'row' => $index + 2
                    ]);
                    continue;
                }

                $data = array_combine($header, $row);
                $earnings = [
    'total_earnings' => (float) ($data['Paid to you : Your earnings'] ?? 0),

    'fare' => [
        'base_fare' => (float) ($data['Paid to you:Your earnings:Fare:Fare'] ?? 0),
        'booking_fee' => (float) ($data['Paid to you:Your earnings:Fare:Booking fee'] ?? 0),
        'outskirt_surcharge' => (float) ($data['Paid to you:Your earnings:Fare:Outskirt Surcharge'] ?? 0),
        'wait_time' => (float) ($data['Paid to you:Your earnings:Fare:Wait Time at Pick-up'] ?? 0),
        'package_fare' => (float) ($data['Paid to you:Your earnings:Fare:Package Fare'] ?? 0),
        'additional_distance' => (float) ($data['Paid to you:Your earnings:Fare:Additional distance charges'] ?? 0),
        'additional_time' => (float) ($data['Paid to you:Your earnings:Fare:Additional time charges'] ?? 0),
        'surge' => (float) ($data['Paid to you:Your earnings:Fare:Surge'] ?? 0),
        'cancellation' => (float) ($data['Paid to you:Your earnings:Fare:Cancellation'] ?? 0),
        'reservation_fee' => (float) ($data['Paid to you:Your earnings:Fare:Reservation Fee'] ?? 0),
        'fare_adjustment' => (float) ($data['Paid to you:Your earnings:Fare:Fare Adjustment'] ?? 0),
        'adjustment' => (float) ($data['Paid to you:Your earnings:Fare:Adjustment'] ?? 0),
        'extended_wait_cancel_fee' => (float) ($data['Paid to you:Your earnings:Fare:Additional cancellation fee for extended wait time'] ?? 0),
    ],

    'taxes' => [
        'tax' => (float) ($data['Paid to you : Your earnings : Taxes'] ?? 0),
        'income_tax_withholding' => (float) ($data['Paid to you:Your earnings:Taxes:Income tax withholding'] ?? 0),
        'tds_on_promotions' => (float) ($data['Paid to you:Your earnings:Taxes:TDS on promotions'] ?? 0),
    ],

    'promotion' => [
        'promotion' => (float) ($data['Paid to you:Your earnings:Promotion:Promotion'] ?? 0),
        'quest' => (float) ($data['Paid to you:Your earnings:Promotion:Quest'] ?? 0),
    ],

    'tip' => (float) ($data['Paid to you:Your earnings:Tip'] ?? 0),
];

$tripBalance = [
    'cash_collected' => (float) ($data['Paid to you : Trip balance : Payouts : Cash collected'] ?? 0),

    'refunds' => [
        'toll' => (float) ($data['Paid to you:Trip balance:Refunds:Toll'] ?? 0),
    ],

    'expenses' => [
        'toll_adjustment' => (float) ($data['Paid to you:Trip balance:Expenses:Toll adjustment'] ?? 0),
        'driver_subscription_charge' => (float) ($data['Paid to you:Trip balance:Expenses:Driver subscription charge'] ?? 0),
    ],

    'taxes' => [
        'tax' => (float) ($data['Paid to you:Trip balance:Taxes:Tax'] ?? 0),
    ],

    'payouts' => [
        'bank_transfer' => (float) ($data['Paid to you:Trip balance:Payouts:Transferred To Bank Account'] ?? 0),
    ],
];


                DriverFinancialTransaction::create([
                    'transaction_uuid' => $data['transaction UUID'] ?? uniqid(),
                    'driver_uuid' => $data['Driver UUID'] ?? 'unknown',
                    'trip_uuid' => $data['Trip UUID'] ?? null,
                    'driver_name' =>
                        ($data['Driver first name'] ?? '') . ' ' .
                        ($data['Driver surname'] ?? ''),
                    'organisation_name' => $data['Organisation name'] ?? '',
                    'reported_at' => now(),
                    'summary_amount' => (float)($data['Paid to you'] ?? 0),
                    'earnings_json' => $earnings,
                    'trip_balance_json' => $tripBalance,
                    'raw_row_json' => $data
                ]);

                $inserted++;
            }

            return response()->json([
                'status' => true,
                'rows_inserted' => $inserted
            ]);

        } catch (\Exception $e) {

            Log::error('UPLOAD FAILED', [
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
