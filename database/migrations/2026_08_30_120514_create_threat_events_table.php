<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('threat_events', function (Blueprint $table) {
            $table->id();
            $table->string('source_ip');
            $table->string('destination_ip');
            $table->string('threat_type'); // e.g., 'SSH Brute Force', 'SQL Injection', 'DDoS'
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->string('location')->nullable(); // e.g., 'US', 'DE', 'CN'
            $table->text('payload_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threat_events');
    }
};