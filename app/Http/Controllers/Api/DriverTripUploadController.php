<?php

// app/Http/Controllers/Api/DriverTripUploadController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DriverTripImport;
use Illuminate\Support\Str;

class DriverTripUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        $batchId = Str::uuid()->toString();

        Excel::import(
            new DriverTripImport($batchId),
            $request->file('file')
        );

        return response()->json([
            'message' => 'Trip data uploaded successfully',
            'upload_batch_id' => $batchId
        ]);
    }
}
