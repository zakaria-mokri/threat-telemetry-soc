<?php

namespace App\Http\Controllers;

use App\Models\ThreatEvent;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $initialEvents = ThreatEvent::latest()->take(10)->get();
        
        return view('dashboard', compact('initialEvents'));
    }
}