<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel 11">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=flat&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/WebSockets-Reverb-4A154B?style=flat&logo=laravel&logoColor=white" alt="Laravel Reverb">
  <img src="https://img.shields.io/badge/License-MIT-brightgreen" alt="License MIT">
</p>

# THREAT // TELEMETRY SOC

A real-time Security Operations Center (SOC) dashboard designed to ingest, visualize, and monitor global threat intelligence and live attack vectors. Built with Laravel 11, WebSockets, and modern front-end components for high-concurrency event telemetry.

---

## 📸 Dashboard Overview

<p align="center">
  <img src="public/assets/images/dashboard-map.jpg" alt="SOC Threat Map" width="100%">
</p>

<br>

<p align="center">
  <img src="https://github.com/user-attachments/assets/36386113-d97d-4495-b8da-bb8fcd5f5f83" alt="Live Telemetry Feed" width="100%">
</p>

---

## 🔥 Key Features

* **Global Attack Arc Mapping**: Visualizes geographical threat origins, targeted endpoints, and high-risk vector trajectories in real time.
* **Real-Time Telemetry Feed**: Live event streaming for incoming security events including DDoS vectors, XSS payloads, and unauthorized port scans.
* **Metrics & Severity Breakdown**: Aggregates global threat severity levels (Critical, High, Medium, Low) and event velocity ($E/s$).
* **WebSocket Integration**: Low-latency event dispatching using Laravel Reverb for real-time telemetry rendering without page reloads.

---

## 🛠️ Tech Stack

* **Backend Framework**: Laravel 11 (PHP 8.2+)
* **Real-Time Engine**: Laravel Reverb / WebSockets
* **Frontend UI**: Blade, Tailwind CSS, Alpine.js / React
* **Database**: MySQL / PostgreSQL
* **API Architecture**: RESTful Event Ingestion Pipelines

---

## ⚡ Getting Started

### Prerequisites

* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL or PostgreSQL database

### Installation

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/your-username/threat-telemetry-soc.git](https://github.com/your-username/threat-telemetry-soc.git)
   cd threat-telemetry-soc
