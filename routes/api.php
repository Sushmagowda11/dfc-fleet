<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DriverActivityUploadController;
use App\Http\Controllers\Api\DriverAutoPositioningUploadController;
use App\Http\Controllers\Api\DriverTripUploadController;
use App\Http\Controllers\Api\FinancialTransactionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post(
    '/upload/driver-activity',
    [DriverActivityUploadController::class, 'upload']
);

Route::post(
    '/upload/driver-auto-positioning',
    [DriverAutoPositioningUploadController::class, 'upload']
);



Route::post(
    '/upload/driver-trips',
    [DriverTripUploadController::class, 'upload']
);

Route::post(
    '/financial-transactions/upload',
    [FinancialTransactionController::class, 'upload']
);

