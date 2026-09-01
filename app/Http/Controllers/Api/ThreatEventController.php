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
        $query = ThreatEvent::query();

        if (request()->filled('severity')) {
            $query->where('severity', request('severity'));
        }

        if (request()->filled('threat_type')) {
            $query->where(
                'threat_type',
                'like',
                '%' . request('threat_type') . '%'
            );
        }

        if (request()->filled('source_ip')) {
            $query->where('source_ip', request('source_ip'));
        }

        $events = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

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

    public function destroy(ThreatEvent $threatEvent): JsonResponse
    {
        $threatEvent->delete();

        return response()->json([
            'message' => 'Threat event deleted successfully.',
        ]);
    }
}