<?php

namespace App\Console\Commands;

use App\Events\ThreatDetected;
use App\Models\ThreatEvent;
use Illuminate\Console\Command;

class StreamThreatTelemetry extends Command
{
    protected $signature = 'telemetry:stream {--interval=2 : Delay in seconds between events}';
    protected $description = 'Simulate live security threats and broadcast them via WebSockets';

    private array $threatTypes = [
        'SSH Brute Force' => ['severity' => 'high', 'details' => 'Repeated failed auth attempts on port 22'],
        'SQL Injection' => ['severity' => 'critical', 'details' => "UNION SELECT statement detected in GET request"],
        'DDoS Vector' => ['severity' => 'critical', 'details' => 'SYN Flood targeting public port 443'],
        'XSS Payload' => ['severity' => 'medium', 'details' => '<script> alert(1) </script> reflected in input'],
        'Port Scan' => ['severity' => 'low', 'details' => 'Sequential port probing detected across range 1-1024'],
    ];

    private array $locations = ['US', 'DE', 'CN', 'RU', 'BR', 'NL', 'JP'];

    public function handle(): void
    {
        $interval = (int) $this->option('interval');
        $this->info("🚀 Starting live threat telemetry stream (Interval: {$interval}s)...");

        while (true) {
            $threatName = array_rand($this->threatTypes);
            $threatData = $this->threatTypes[$threatName];

            $event = ThreatEvent::create([
                'source_ip' => rand(1, 255) . '.' . rand(0, 255) . '.' . rand(0, 255) . '.' . rand(1, 255),
                'destination_ip' => '10.0.4.12',
                'threat_type' => $threatName,
                'severity' => $threatData['severity'],
                'location' => $this->locations[array_rand($this->locations)],
                'payload_details' => $threatData['details'],
            ]);

            event(new ThreatDetected($event));

            $this->line(" [<comment>" . now()->format('H:i:s') . "</comment>] Captured <fg=red>{$threatName}</> from <fg=yellow>{$event->source_ip}</>");

            sleep($interval);
        }
    }
}