<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat&logo=php&logoColor=white" alt="PHP 8.3+">
  <img src="https://img.shields.io/badge/Reverb-WebSockets-4A154B?style=flat&logo=laravel&logoColor=white" alt="Laravel Reverb">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=flat&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
</p>

# THREAT // TELEMETRY SOC

THREAT // TELEMETRY SOC is a real-time Security Operations Center dashboard built with Laravel and WebSockets.

The project focuses on visualizing simulated security telemetry, threat severity, attack activity, and live event updates through a responsive monitoring interface.

It demonstrates real-time Laravel application development using Laravel Reverb, Laravel Echo, Alpine.js, Tailwind CSS, and event-driven frontend updates.

## Dashboard Preview

<p align="center">
  <img src="public/assets/images/dashboard-map.jpg" alt="SOC Threat Map" width="100%">
</p>

<br>

<p align="center">
  <img src="https://github.com/user-attachments/assets/36386113-d97d-4495-b8da-bb8fcd5f5f83" alt="Live Telemetry Feed" width="100%">
</p>

## Features

* Real-time security telemetry dashboard
* Global threat visualization
* Simulated attack origin and target mapping
* Live telemetry event feed
* Threat severity classification
* Critical, high, medium, and low severity metrics
* Event-rate monitoring
* Laravel Reverb WebSocket integration
* Laravel Echo frontend subscriptions
* Alpine.js-driven interface behavior
* Responsive dashboard layout
* Tailwind CSS 4 styling
* Vite-powered frontend asset pipeline

## Tech Stack

### Backend

* PHP 8.3+
* Laravel 13
* Laravel Reverb
* Laravel Broadcasting

### Real-Time Communication

* WebSockets
* Laravel Echo
* Pusher JS

### Frontend

* Blade
* Alpine.js 3
* Tailwind CSS 4
* Vite 8

### Development & Testing

* PHPUnit 12
* Laravel Pint
* Laravel Pail
* Faker
* Mockery

## Architecture

```text
Security Telemetry / Events
           │
           ▼
     Laravel Backend
           │
           ├── Event Generation
           │
           ├── Application Logic
           │
           └── Broadcasting
                  │
                  ▼
           Laravel Reverb
                  │
                  ▼
             WebSocket
                  │
                  ▼
           Laravel Echo
                  │
                  ▼
        Alpine.js Dashboard
                  │
                  ▼
      Real-Time SOC Interface
```

The application uses Laravel's broadcasting system together with Reverb to push events to connected clients without requiring full-page refreshes.

## Real-Time Event Flow

A typical event flow follows this process:

```text
Security Event
     │
     ▼
Laravel Application
     │
     ▼
Broadcast Event
     │
     ▼
Laravel Reverb
     │
     ▼
WebSocket Connection
     │
     ▼
Laravel Echo
     │
     ▼
Dashboard Update
```

This architecture allows dashboard components to react to new telemetry as events are broadcast.

## Frontend Real-Time Integration

The frontend initializes Laravel Echo and Alpine.js through the application's JavaScript entry point.

```text
resources/js/app.js
        │
        ├── Laravel Echo
        │
        └── Alpine.js
```

Laravel Echo handles real-time broadcast subscriptions, while Alpine.js provides lightweight reactive behavior for dashboard components.

## Dashboard

The main application route renders the SOC dashboard through Laravel's `DashboardController`.

```http
GET /
```

The dashboard presents threat telemetry and monitoring information through a single operational interface.

## Threat Telemetry

The interface is designed around common SOC-style telemetry concepts, including:

* Threat origin
* Target endpoint
* Attack type
* Severity
* Event timestamp
* Event frequency
* Threat activity
* Operational metrics

Example simulated threat categories may include:

```text
DDoS
XSS
Port Scan
Unauthorized Access
Suspicious Network Activity
```

The project is intended as a visualization and software engineering demonstration rather than a production intrusion-detection system.

## Project Structure

```text
.
├── app/
│   ├── Events/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   └── Providers/
│
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   └── assets/
│       └── images/
│
├── resources/
│   ├── css/
│   ├── js/
│   │   ├── app.js
│   │   └── echo.js
│   └── views/
│
├── routes/
│   ├── channels.php
│   ├── console.php
│   └── web.php
│
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
└── vite.config.js
```

## Getting Started

### Requirements

Make sure the following are installed:

* PHP 8.3+
* Composer
* Node.js
* npm

## 1. Clone the Repository

```bash
git clone https://github.com/zakaria-mokri/threat-telemetry-soc.git
cd threat-telemetry-soc
```

## 2. Install and Configure the Application

The repository includes a Composer setup script.

Run:

```bash
composer run setup
```

This performs the initial Laravel setup, including dependency installation, environment configuration, migrations, frontend dependency installation, and asset compilation.

Alternatively, configure the project manually.

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Run database migrations:

```bash
php artisan migrate
```

Install frontend dependencies:

```bash
npm install
```

Build frontend assets:

```bash
npm run build
```

## 3. Start the Development Environment

Run:

```bash
composer run dev
```

Alternatively, start the services individually.

Laravel application:

```bash
php artisan serve
```

Vite:

```bash
npm run dev
```

Laravel Reverb:

```bash
php artisan reverb:start
```

The Laravel application will normally be available at:

```text
http://localhost:8000
```

## WebSocket Configuration

Laravel Reverb requires broadcasting configuration in the application environment.

Your `.env` configuration should contain the broadcasting and Reverb values required by your local environment.

Example structure:

```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=your_app_id
REVERB_APP_KEY=your_app_key
REVERB_APP_SECRET=your_app_secret

REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http
```

Do not commit real production credentials or secrets to GitHub.

## Frontend Development

Run the Vite development server with:

```bash
npm run dev
```

Create a production build with:

```bash
npm run build
```

## Testing

Run the Laravel test suite with:

```bash
composer test
```

or:

```bash
php artisan test
```

## Code Quality

Laravel Pint is included for PHP code formatting.

Run:

```bash
./vendor/bin/pint
```

Laravel Pail is also included for application log inspection during development.

## Engineering Concepts Demonstrated

This project demonstrates experience with:

* Laravel application development
* PHP backend development
* Event-driven architecture
* WebSocket communication
* Laravel Broadcasting
* Laravel Reverb
* Laravel Echo
* Real-time frontend updates
* Blade templates
* Alpine.js
* Tailwind CSS
* Responsive dashboard design
* Vite
* Server-to-client event delivery
* Environment-based configuration
* Automated testing with PHPUnit
* PHP code formatting with Laravel Pint

## Security Context

THREAT // TELEMETRY SOC is designed as a software engineering and visualization project.

The dashboard represents SOC-style security telemetry but is not intended to replace a production SIEM, IDS, IPS, EDR, or other enterprise security monitoring platform.

Threat events and attack visualizations should be understood as simulated or application-provided telemetry unless connected to a real security data source.

## Future Improvements

Potential improvements include:

* REST API for external threat event ingestion
* Authenticated event ingestion endpoints
* Persistent threat event storage
* PostgreSQL-backed telemetry history
* Redis caching
* Queue-based event processing
* Authentication and role-based access control
* Analyst accounts and permissions
* Event filtering and search
* Threat severity filtering
* Historical trend charts
* Incident creation from threat events
* Threat acknowledgment workflows
* MITRE ATT&CK mapping
* GeoIP enrichment
* External threat intelligence feeds
* Rate limiting
* API authentication
* Expanded PHPUnit feature tests
* GitHub Actions CI
* Docker development environment
* Structured logging and observability

## Purpose

This project was built to explore real-time application architecture using Laravel's event broadcasting ecosystem.

It combines backend event handling, WebSocket communication, reactive frontend behavior, and a SOC-inspired interface to demonstrate how Laravel can be used to build live monitoring applications.

## Disclaimer

This repository is an educational and portfolio software engineering project.

It does not provide production-grade threat detection or security monitoring capabilities and should not be treated as a substitute for professional cybersecurity infrastructure.
