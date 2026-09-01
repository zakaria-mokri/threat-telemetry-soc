<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreThreatEventRequest;
use App\Http\Requests\UpdateThreatEventRequest;
use App\Models\ThreatEvent;
use Illuminate\Http\JsonResponse;

class ThreatEventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = ThreatEvent::latest()->paginate(20);

        return response()->json($events);
    }

    public function show(ThreatEvent $threatEvent): JsonResponse
    {
        return response()->json([
            'data' => $threatEvent,
        ]);
    }

    public function store(StoreThreatEventRequest $request): JsonResponse
    {
        $event = ThreatEvent::create($request->validated());

        return response()->json([
            'message' => 'Threat event created successfully.',
            'data' => $event,
        ], 201);
    }

    public function update(
        UpdateThreatEventRequest $request,
        ThreatEvent $threatEvent
    ): JsonResponse {
        $threatEvent->update($request->validated());

        return response()->json([
            'message' => 'Threat event updated successfully.',
            'data' => $threatEvent->fresh(),
        ]);
    }
}