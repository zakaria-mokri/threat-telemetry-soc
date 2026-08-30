<?php

namespace App\Events;

use App\Models\ThreatEvent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreatDetected implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public ThreatEvent $threatEvent)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('threat-telemetry'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'threat.received';
    }
}