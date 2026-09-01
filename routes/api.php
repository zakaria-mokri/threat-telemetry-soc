<?php

use App\Http\Controllers\Api\ThreatEventController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'threat-telemetry-soc',
    ]);
});

Route::get('/threat-events', [ThreatEventController::class, 'index']);