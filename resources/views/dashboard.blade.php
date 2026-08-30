<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100 text-slate-900 selection:bg-cyan-500 selection:text-white">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOC Cyber Threat Telemetry</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="h-full flex flex-col font-mono antialiased bg-slate-100" x-data="threatDashboard({{ $initialEvents->toJson() }})">

    <header class="border-b border-slate-200 bg-white px-6 py-4 flex justify-between items-center shadow-xs">
        <div class="flex items-center space-x-3">
            <div class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-cyan-600"></span>
            </div>
            <h1 class="text-xl font-black tracking-widest text-slate-900">
                THREAT // TELEMETRY SOC
            </h1>
        </div>

        <div class="flex items-center space-x-4 text-xs">
            <div class="bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-md flex items-center space-x-2 shadow-2xs">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-slate-500">REVERB WS:</span>
                <span class="text-emerald-600 font-bold uppercase tracking-wider">Connected</span>
            </div>
        </div>
    </header>

    <main class="flex-1 p-6 grid grid-cols-1 lg:grid-cols-4 gap-6 overflow-hidden">
        
        <section class="lg:col-span-3 flex flex-col gap-6 overflow-hidden">
            
            <div class="border border-slate-200 rounded-xl bg-white p-5 relative shadow-xs flex flex-col h-80">
                <div class="flex justify-between items-center mb-2 z-10">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-cyan-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Global Attack Arc Map
                    </h2>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Target: 10.0.4.12 (HQ)</span>
                </div>

                <div id="map" class="w-full flex-1 rounded-lg border border-slate-200 bg-slate-50 z-0"></div>
            </div>

            <div class="flex-1 border border-slate-200 rounded-xl bg-white p-5 flex flex-col overflow-hidden shadow-xs">
                <div class="flex justify-between items-center mb-3 pb-2 border-b border-slate-100">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-cyan-700">Live Telemetry Feed</h2>
                    <span class="text-xs text-slate-400" x-text="`Showing latest ${events.length} events`"></span>
                </div>

                <div class="flex-1 overflow-y-auto space-y-2 pr-1">
                    <template x-for="event in events" :key="event.id">
                        <div @click="selectedEvent = event" 
                             class="cursor-pointer group p-3 rounded-lg border bg-slate-50 flex items-center justify-between transition-all duration-150 hover:bg-white hover:shadow-md"
                             :class="{
                                 'border-red-200 hover:border-red-400': event.severity === 'critical',
                                 'border-orange-200 hover:border-orange-400': event.severity === 'high',
                                 'border-yellow-200 hover:border-yellow-400': event.severity === 'medium',
                                 'border-blue-200 hover:border-blue-400': event.severity === 'low'
                             }">
                            <div class="flex items-center space-x-3">
                                <span class="px-2.5 py-1 text-[10px] font-black tracking-wider uppercase rounded-md shadow-2xs"
                                      :class="{
                                          'bg-red-50 text-red-700 border border-red-200': event.severity === 'critical',
                                          'bg-orange-50 text-orange-700 border border-orange-200': event.severity === 'high',
                                          'bg-yellow-50 text-yellow-800 border border-yellow-200': event.severity === 'medium',
                                          'bg-blue-50 text-blue-700 border border-blue-200': event.severity === 'low'
                                      }" x-text="event.severity"></span>
                                <div>
                                    <h3 class="text-xs font-bold text-slate-900 group-hover:text-cyan-700 transition" x-text="event.threat_type"></h3>
                                    <p class="text-[11px] text-slate-500 mt-0.5">
                                        SRC: <span class="text-cyan-700 font-bold" x-text="event.source_ip"></span>
                                        <span class="text-slate-300 mx-1">&rarr;</span>
                                        DST: <span class="text-slate-700 font-medium" x-text="event.destination_ip"></span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-0.5 text-[9px] font-bold bg-slate-200 text-slate-700 rounded border border-slate-300 uppercase tracking-widest inline-block mb-1" x-text="event.location || 'UNKNOWN'"></span>
                                <span class="text-[11px] text-slate-400 block" x-text="formatTime(event.created_at)"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        <aside class="space-y-6 flex flex-col justify-between">
            <div class="border border-slate-200 rounded-xl bg-white p-5 shadow-xs space-y-6">
                <h2 class="text-xs font-bold uppercase tracking-widest text-slate-400 pb-2 border-b border-slate-100">
                    Metrics Overview
                </h2>

                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-1">Global Threat</span>
                        <div class="relative w-20 h-20 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-slate-200" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path :class="getThreatScore() >= 50 ? 'text-red-500' : 'text-emerald-500'" 
                                      :stroke-dasharray="`${getThreatScore()}, 100`" 
                                      stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" 
                                      d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" class="transition-all duration-500" />
                            </svg>
                            <span class="absolute text-xs font-black text-slate-900" x-text="getThreatScore() + '%'"></span>
                        </div>
                    </div>

                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg flex flex-col items-center">
                        <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mb-1">Velocity</span>
                        <div class="relative w-20 h-20 flex items-center justify-center">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-slate-200" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="text-cyan-600" stroke-dasharray="65, 100" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            </svg>
                            <span class="absolute text-xs font-black text-slate-900" x-text="velocity + ' E/s'"></span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg">
                    <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider block mb-1">Total Threats Captured</span>
                    <span class="text-3xl font-black text-slate-900" x-text="events.length"></span>
                </div>

                <div class="p-4 bg-white border border-slate-200 rounded-lg space-y-2 text-xs shadow-2xs">
                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-bold mb-2">Severity Breakdown</span>
                    <div class="flex justify-between items-center"><span class="text-red-600 font-bold">CRITICAL</span><span class="font-bold text-slate-900" x-text="getSeverityCount('critical')"></span></div>
                    <div class="flex justify-between items-center"><span class="text-orange-600 font-bold">HIGH</span><span class="font-bold text-slate-900" x-text="getSeverityCount('high')"></span></div>
                    <div class="flex justify-between items-center"><span class="text-yellow-700 font-bold">MEDIUM</span><span class="font-bold text-slate-900" x-text="getSeverityCount('medium')"></span></div>
                    <div class="flex justify-between items-center"><span class="text-blue-600 font-bold">LOW</span><span class="font-bold text-slate-900" x-text="getSeverityCount('low')"></span></div>
                </div>
            </div>
        </aside>
    </main>

    <div x-show="selectedEvent" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 z-50" style="display: none;">
        <div @click.away="selectedEvent = null" class="bg-white border border-slate-200 rounded-xl p-6 max-w-lg w-full shadow-2xl space-y-4">
            <div class="flex justify-between items-start border-b border-slate-100 pb-3">
                <h3 class="text-base font-bold text-slate-900" x-text="selectedEvent?.threat_type"></h3>
                <button @click="selectedEvent = null" class="text-slate-400 hover:text-slate-700 text-lg font-bold">&times;</button>
            </div>
            <div class="space-y-2 text-xs">
                <p><span class="text-slate-400">Source IP:</span> <span class="text-cyan-700 font-bold" x-text="selectedEvent?.source_ip"></span></p>
                <p><span class="text-slate-400">Destination IP:</span> <span class="text-slate-700 font-semibold" x-text="selectedEvent?.destination_ip"></span></p>
                <p><span class="text-slate-400">Location:</span> <span class="text-slate-700 font-semibold" x-text="selectedEvent?.location"></span></p>
                <div class="mt-4">
                    <span class="text-slate-500 block font-bold mb-1">Payload / Telemetry Log:</span>
                    <pre class="bg-slate-900 p-3 rounded-lg border border-slate-800 text-xs text-emerald-400 overflow-x-auto whitespace-pre-wrap font-mono" x-text="selectedEvent?.payload_details || 'SELECT * FROM users WHERE id = 1 OR 1=1;'"></pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        function threatDashboard(initialEvents) {
            return {
                events: initialEvents,
                selectedEvent: null,
                velocity: 0.5,
                map: null,
                coords: {
                    US: [37.0902, -95.7129],
                    DE: [51.1657, 10.4515],
                    CN: [35.8617, 104.1954],
                    RU: [61.5240, 105.3188],
                    BR: [-14.2350, -51.9253],
                    NL: [52.1326, 5.2913],
                    JP: [36.2048, 138.2529],
                },

                init() {
                    this.initMap();

                    window.Echo.channel('threat-telemetry')
                        .listen('.threat.received', (e) => {
                            this.events.unshift(e.threatEvent);
                            if (this.events.length > 50) this.events.pop();
                            this.plotThreatOnMap(e.threatEvent);
                        });
                },

                initMap() {
                    this.map = L.map('map', { zoomControl: false, attributionControl: false }).setView([20, 0], 2);
                    
                    // Clean, watermark-free light gray canvas basemap from Esri
                    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/Canvas/World_Light_Gray_Base/MapServer/tile/{z}/{y}/{x}', {
                        maxZoom: 16,
                    }).addTo(this.map);
                },

                plotThreatOnMap(event) {
                    const country = event.location || 'US';
                    const srcCoords = this.coords[country] || [37.0902, -95.7129];
                    const dstCoords = [38.9072, -77.0369];

                    const color = event.severity === 'critical' ? '#dc2626' : (event.severity === 'high' ? '#ea580c' : '#0284c7');

                    const marker = L.circleMarker(srcCoords, {
                        radius: 6,
                        color: color,
                        fillColor: color,
                        fillOpacity: 0.9
                    }).addTo(this.map);

                    const line = L.polyline([srcCoords, dstCoords], {
                        color: color,
                        weight: 2,
                        opacity: 0.8,
                        dashArray: '4, 6'
                    }).addTo(this.map);

                    setTimeout(() => {
                        this.map.removeLayer(marker);
                        this.map.removeLayer(line);
                    }, 3500);
                },

                getSeverityCount(sev) {
                    return this.events.filter(e => e.severity === sev).length;
                },

                getThreatScore() {
                    if (!this.events.length) return 0;
                    const criticals = this.getSeverityCount('critical') * 3;
                    const highs = this.getSeverityCount('high') * 2;
                    const totalScore = ((criticals + highs) / (this.events.length * 3)) * 100;
                    return Math.min(Math.round(totalScore), 100);
                },

                formatTime(timestamp) {
                    if (!timestamp) return 'Just now';
                    return new Date(timestamp).toLocaleTimeString();
                }
            };
        }
    </script>
</body>
</html>