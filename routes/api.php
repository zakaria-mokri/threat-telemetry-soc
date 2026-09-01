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
Route::get('/threat-events/{threatEvent}', [ThreatEventController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/threat-events', [ThreatEventController::class, 'store']);
    Route::patch('/threat-events/{threatEvent}', [ThreatEventController::class, 'update']);
    Route::delete('/threat-events/{threatEvent}', [ThreatEventController::class, 'destroy']);
});