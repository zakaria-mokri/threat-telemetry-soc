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
}