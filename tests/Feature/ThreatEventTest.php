<?php

namespace Tests\Feature;

use App\Models\ThreatEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreatEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_recent_threat_events(): void
    {
        ThreatEvent::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('initialEvents');

        $initialEvents = $response->viewData('initialEvents');

        $this->assertCount(3, $initialEvents);
    }

    public function test_api_returns_paginated_threat_events(): void
    {
        ThreatEvent::factory()->count(3)->create();

        $response = $this->getJson('/api/threat-events');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'source_ip',
                        'destination_ip',
                        'threat_type',
                        'severity',
                        'location',
                        'payload_details',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'current_page',
                'last_page',
                'per_page',
                'total',
            ]);
    }

    public function test_api_can_return_a_single_threat_event(): void
    {
        $event = ThreatEvent::factory()->create([
            'source_ip' => '203.0.113.10',
            'threat_type' => 'Port Scan',
            'severity' => 'medium',
        ]);

        $response = $this->getJson("/api/threat-events/{$event->id}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $event->id)
            ->assertJsonPath('data.source_ip', '203.0.113.10')
            ->assertJsonPath('data.threat_type', 'Port Scan')
            ->assertJsonPath('data.severity', 'medium');
    }

    public function test_api_returns_404_for_missing_threat_event(): void
    {
        $response = $this->getJson('/api/threat-events/999999');

        $response->assertStatus(404);
    }

    public function test_api_can_create_a_threat_event(): void
    {
        $payload = [
            'source_ip' => '192.168.1.10',
            'destination_ip' => '10.0.0.5',
            'threat_type' => 'SSH Brute Force',
            'severity' => 'high',
            'location' => 'DE',
            'payload_details' => 'Multiple failed login attempts detected.',
        ];

        $response = $this->postJson('/api/threat-events', $payload);

        $response
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Threat event created successfully.',
            ])
            ->assertJsonPath('data.source_ip', '192.168.1.10')
            ->assertJsonPath('data.severity', 'high');

        $this->assertDatabaseHas('threat_events', [
            'source_ip' => '192.168.1.10',
            'destination_ip' => '10.0.0.5',
            'threat_type' => 'SSH Brute Force',
            'severity' => 'high',
        ]);
    }

    public function test_api_rejects_invalid_threat_event_data(): void
    {
        $response = $this->postJson('/api/threat-events', [
            'source_ip' => 'not-an-ip',
            'destination_ip' => '',
            'threat_type' => '',
            'severity' => 'extreme',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'source_ip',
                'destination_ip',
                'threat_type',
                'severity',
            ]);
    }

    public function test_api_can_update_a_threat_event(): void
    {
        $event = ThreatEvent::factory()->create([
            'severity' => 'low',
            'threat_type' => 'Port Scan',
        ]);

        $response = $this->patchJson("/api/threat-events/{$event->id}", [
            'severity' => 'critical',
            'threat_type' => 'DDoS',
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Threat event updated successfully.',
            ])
            ->assertJsonPath('data.severity', 'critical')
            ->assertJsonPath('data.threat_type', 'DDoS');

        $this->assertDatabaseHas('threat_events', [
            'id' => $event->id,
            'severity' => 'critical',
            'threat_type' => 'DDoS',
        ]);
    }

    public function test_api_rejects_invalid_update_data(): void
    {
        $event = ThreatEvent::factory()->create();

        $response = $this->patchJson("/api/threat-events/{$event->id}", [
            'source_ip' => 'invalid-ip',
            'severity' => 'extreme',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'source_ip',
                'severity',
            ]);
    }


public function test_api_can_delete_a_threat_event(): void
{
    $event = ThreatEvent::factory()->create();

    $response = $this->deleteJson("/api/threat-events/{$event->id}");

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Threat event deleted successfully.',
        ]);

    $this->assertDatabaseMissing('threat_events', [
        'id' => $event->id,
    ]);
}

public function test_api_returns_404_when_deleting_missing_threat_event(): void
{
    $response = $this->deleteJson('/api/threat-events/999999');

    $response->assertStatus(404);
}


}