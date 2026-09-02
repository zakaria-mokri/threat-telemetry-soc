<?php

namespace Database\Seeders;

use App\Models\ThreatEvent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (ThreatEvent::count() === 0) {
            ThreatEvent::factory()
                ->count(30)
                ->create();
        }
    }
}