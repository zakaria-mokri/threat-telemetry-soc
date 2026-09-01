<?php

namespace Database\Factories;

use App\Models\ThreatEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ThreatEvent>
 */
class ThreatEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source_ip' => fake()->ipv4(),
            'destination_ip' => fake()->ipv4(),
            'threat_type' => fake()->randomElement([
                'SSH Brute Force',
                'SQL Injection',
                'DDoS',
                'XSS',
                'Port Scan',
            ]),
            'severity' => fake()->randomElement([
                'low',
                'medium',
                'high',
                'critical',
            ]),
            'location' => fake()->countryCode(),
            'payload_details' => fake()->sentence(),
        ];
    }
}