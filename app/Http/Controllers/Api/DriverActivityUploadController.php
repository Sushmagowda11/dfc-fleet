<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DriverActivityImport;

class DriverActivityUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        Excel::import(new DriverActivityImport, $request->file('file'));

        return response()->json([
            'status' => true,
            'message' => 'Driver Activity data uploaded successfully'
        ]);
    }
}
