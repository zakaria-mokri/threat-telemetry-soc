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
}