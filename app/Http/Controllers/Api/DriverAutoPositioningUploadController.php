<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DriverAutoPositioningImport;

class DriverAutoPositioningUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx'
        ]);

        $batchId = now()->format('YmdHis');

        Excel::import(
            new DriverAutoPositioningImport($batchId),
            $request->file('file')
        );

        return response()->json([
            'status' => true,
            'message' => 'Driver Auto Positioning data uploaded successfully'
        ]);
    }
}
