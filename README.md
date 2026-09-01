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

# Threat Telemetry SOC

![Tests](https://github.com/zakaria-mokri/threat-telemetry-soc/actions/workflows/tests.yml/badge.svg)

A Laravel-based Security Operations Center dashboard for collecting, storing, and visualizing threat telemetry.

The project simulates a lightweight SOC environment where security events such as brute-force attempts, SQL injection, DDoS activity, port scans, and other suspicious traffic can be persisted, exposed through a REST API, and displayed through a monitoring dashboard.

---

## Overview

Threat Telemetry SOC is designed as a portfolio project demonstrating backend engineering, API design, automated testing, real-time application architecture, and modern Laravel development practices.

The application currently includes:

- Persistent threat-event storage
- SOC monitoring dashboard
- REST API for threat events
- Request validation
- Pagination
- Automated feature tests
- API health monitoring
- Real-time communication tooling with Laravel Reverb
- GitHub Actions continuous integration

---

## Screenshots

### SOC Dashboard

![Threat Telemetry SOC Dashboard](public/assets/images/dashboard-map.jpg)

### Live Telemetry

![Live Threat Telemetry](https://github.com/user-attachments/assets/36386113-d97d-4495-b8da-bb8fcd5f5f83)

---

## Features

### Threat Event Management

Threat events are stored with information such as:

- Source IP address
- Destination IP address
- Threat type
- Severity
- Geographic location
- Payload details
- Creation and update timestamps

Supported severity levels:

```text
low
medium
high
critical
```

Example threat types include:

```text
SSH Brute Force
SQL Injection
DDoS
XSS
Port Scan
```

---

## REST API

The application exposes a JSON API under `/api`.

### Health Check

```http
GET /api/health
```

Example response:

```json
{
    "status": "ok",
    "service": "threat-telemetry-soc"
}
```

### List Threat Events

```http
GET /api/threat-events
```

Returns paginated threat-event records.

Default pagination:

```text
20 events per page
```

### Get Single Threat Event

```http
GET /api/threat-events/{id}
```

Returns a single threat event.

A missing event returns:

```http
404 Not Found
```

### Create Threat Event

```http
POST /api/threat-events
```

Example request:

```json
{
    "source_ip": "192.168.1.10",
    "destination_ip": "10.0.0.5",
    "threat_type": "SSH Brute Force",
    "severity": "high",
    "location": "DE",
    "payload_details": "Multiple failed login attempts detected."
}
```

Example successful response:

```json
{
    "message": "Threat event created successfully.",
    "data": {
        "source_ip": "192.168.1.10",
        "destination_ip": "10.0.0.5",
        "threat_type": "SSH Brute Force",
        "severity": "high",
        "location": "DE",
        "payload_details": "Multiple failed login attempts detected."
    }
}
```

Validation errors return:

```http
422 Unprocessable Entity
```

### Update Threat Event

```http
PATCH /api/threat-events/{id}
```

Example request:

```json
{
    "severity": "critical",
    "threat_type": "DDoS"
}
```

Example response:

```json
{
    "message": "Threat event updated successfully.",
    "data": {
        "severity": "critical",
        "threat_type": "DDoS"
    }
}
```

Partial updates are supported.

---

## API Validation

Incoming threat-event data is validated using dedicated Laravel Form Request classes.

Examples of enforced validation rules include:

```text
source_ip        valid IP address
destination_ip   valid IP address
threat_type      required string
severity         low | medium | high | critical
location         optional string
payload_details  optional string
```

Invalid API requests receive structured JSON validation errors.

---

## Automated Testing

The project includes unit and feature tests using PHPUnit and Laravel's testing utilities.

Current coverage includes:

- Application availability
- API health endpoint
- Dashboard threat-event loading
- Paginated threat-event API
- Single threat-event retrieval
- Missing event handling
- Threat-event creation
- Create-request validation
- Threat-event updates
- Update-request validation

Current test suite:

```text
11 tests
68 assertions
```

Run locally with:

```bash
php artisan test
```

---

## Continuous Integration

GitHub Actions automatically validates the project on:

```text
Pushes to main
Pull requests
```

The CI pipeline performs:

```text
Repository checkout
PHP environment setup
Node.js environment setup
Composer dependency installation
NPM dependency installation
Laravel environment configuration
Frontend production build
Automated PHPUnit tests
```

The current workflow runs on PHP 8.4 because the installed Symfony 8 dependencies require PHP 8.4.1 or newer.

Workflow configuration:

```text
.github/workflows/tests.yml
```

---

## Tech Stack

### Backend

- PHP 8.4+
- Laravel 13
- Laravel Reverb
- Laravel Broadcasting
- Eloquent ORM
- Laravel Form Requests
- PHPUnit

### Frontend

- Blade
- Alpine.js
- Tailwind CSS 4
- Vite 8
- Laravel Echo
- Pusher JS

### Development & Quality

- Composer
- NPM
- Laravel Pint
- Laravel Pail
- GitHub Actions
- SQLite for automated tests

---

## Architecture

A simplified request flow:

```text
Client
  |
  v
Laravel Routes
  |
  v
Controllers
  |
  +----> Form Request Validation
  |
  v
ThreatEvent Model
  |
  v
Database
```

For API creation and update requests:

```text
HTTP Request
    |
    v
Form Request
    |
    +---- invalid ----> 422 JSON response
    |
    v
Controller
    |
    v
Eloquent Model
    |
    v
Database
    |
    v
JSON Response
```

---

## Project Structure

Important directories:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── ThreatEventController.php
│   └── Requests/
│       ├── StoreThreatEventRequest.php
│       └── UpdateThreatEventRequest.php
│
├── Models/
│   └── ThreatEvent.php

database/
├── factories/
│   └── ThreatEventFactory.php
└── migrations/

routes/
├── api.php
├── web.php
└── channels.php

tests/
├── Feature/
└── Unit/

.github/
└── workflows/
    └── tests.yml
```

---

## Local Development

### 1. Clone the repository

```bash
git clone https://github.com/zakaria-mokri/threat-telemetry-soc.git
cd threat-telemetry-soc
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Configure your preferred database inside `.env`.

For SQLite:

```bash
touch database/database.sqlite
```

Then configure:

```env
DB_CONNECTION=sqlite
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. Build frontend assets

```bash
npm run build
```

For frontend development:

```bash
npm run dev
```

### 7. Start Laravel

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

---

## Running Tests

Run the complete suite:

```bash
php artisan test
```

The test environment uses an isolated database through Laravel's `RefreshDatabase` testing support.

---

## Generate Sample Threat Events

The project includes a `ThreatEventFactory` that generates realistic test data including randomized:

```text
IPv4 addresses
Threat types
Severity levels
Country codes
Payload descriptions
```

Example usage through Laravel Tinker:

```bash
php artisan tinker
```

Then:

```php
App\Models\ThreatEvent::factory()->count(20)->create();
```

---

## Current Development Status

Completed:

- Threat-event database model
- Threat-event factory
- SOC dashboard
- Health-check API
- Paginated threat-event API
- Single threat-event API
- Threat-event creation API
- Threat-event update API
- Request validation
- Automated PHPUnit tests
- GitHub Actions CI
- Production frontend build verification

Planned improvements:

- Authentication and authorization
- API token protection
- Role-based access control
- Delete/archive workflow
- API filtering and search
- OpenAPI documentation
- Dockerized development environment
- Public deployed demo
- Expanded security-focused test coverage

---

## Engineering Goals

This project is being developed with an emphasis on professional software engineering practices rather than only feature implementation.

Key goals include:

- Maintainable Laravel architecture
- Explicit input validation
- Predictable REST API behavior
- Automated regression testing
- Continuous integration
- Reproducible development environments
- Clear technical documentation
- Incremental and meaningful Git history

---

## License

This project is intended for educational and portfolio purposes.