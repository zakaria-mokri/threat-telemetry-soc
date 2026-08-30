<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThreatEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_ip',
        'destination_ip',
        'threat_type',
        'severity',
        'location',
        'payload_details',
    ];
}