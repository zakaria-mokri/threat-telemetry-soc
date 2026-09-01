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
}