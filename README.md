<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel 13">
  <img src="https://img.shields.io/badge/PHP-8.4+-777BB4?style=flat&logo=php&logoColor=white" alt="PHP 8.4+">
  <img src="https://img.shields.io/badge/Sanctum-API_Auth-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel Sanctum">
  <img src="https://img.shields.io/badge/Docker-Ready-2496ED?style=flat&logo=docker&logoColor=white" alt="Docker">
  <img src="https://img.shields.io/badge/OpenAPI-3.0-6BA539?style=flat&logo=openapiinitiative&logoColor=white" alt="OpenAPI">
  <img src="https://img.shields.io/badge/Reverb-WebSockets-4A154B?style=flat&logo=laravel&logoColor=white" alt="Laravel Reverb">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=flat&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
</p>

# Threat Telemetry SOC

![Tests](https://github.com/zakaria-mokri/threat-telemetry-soc/actions/workflows/tests.yml/badge.svg)

A Laravel-based Security Operations Center dashboard and REST API for collecting, storing, filtering, managing, and visualizing simulated cyber-threat telemetry.

The project demonstrates backend engineering, REST API design, authentication, automated testing, continuous integration, Docker containerization, OpenAPI documentation, and real-time WebSocket communication.

---

## Overview

Threat Telemetry SOC simulates a lightweight Security Operations Center environment.

Security events such as brute-force attempts, SQL injection attempts, DDoS activity, XSS attacks, and port scans are generated, persisted in the database, exposed through a REST API, and displayed through a live monitoring dashboard.

The project includes:

- Persistent threat-event storage
- Real-time SOC monitoring dashboard
- Live telemetry simulator
- Laravel Reverb WebSocket broadcasting
- Laravel Echo browser subscriptions
- Full CRUD REST API
- Laravel Sanctum API protection
- Public read endpoints
- Protected write endpoints
- Request validation with Laravel Form Requests
- Threat-event filtering
- API pagination
- Automated PHPUnit feature tests
- API health monitoring
- GitHub Actions continuous integration
- Docker support
- OpenAPI 3 specification
- Dedicated API documentation

---

## Screenshots

### SOC Dashboard

![Threat Telemetry SOC Dashboard](public/assets/images/dashboard-map.jpg)

### Live Telemetry

![Live Threat Telemetry](https://github.com/user-attachments/assets/36386113-d97d-4495-b8da-bb8fcd5f5f83)

---

## Real-Time Telemetry

The dashboard receives simulated security events in real time through Laravel Reverb.

The telemetry flow is:

```text
Telemetry Simulator
        |
        v
ThreatEvent Model
        |
        v
SQLite Database
        |
        v
ThreatDetected Event
        |
        v
Laravel Reverb
        |
        v
Laravel Echo
        |
        v
Browser Dashboard
```

A new simulated threat event can be generated every two seconds.

Each event:

- receives a randomized source IP
- receives a threat type
- receives a severity level
- receives a geographic source location
- is persisted to SQLite
- is broadcast through Laravel Reverb
- is received by Laravel Echo
- updates the live telemetry feed
- updates dashboard statistics
- appears on the global threat map

---

## Threat Event Types

Example simulated threats include:

```text
SSH Brute Force
SQL Injection
DDoS Vector
XSS Payload
Port Scan
```

Supported severity levels:

```text
low
medium
high
critical
```

Threat events contain:

- Source IP address
- Destination IP address
- Threat type
- Severity
- Geographic location
- Payload details
- Creation timestamp
- Update timestamp

---

## REST API

Base path:

```text
/api
```

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

---

### List Threat Events

```http
GET /api/threat-events
```

Returns paginated threat-event records.

Default pagination:

```text
20 events per page
```

Supported filters:

```text
severity
threat_type
source_ip
```

Examples:

```http
GET /api/threat-events?severity=critical
GET /api/threat-events?threat_type=SSH
GET /api/threat-events?source_ip=203.0.113.50
```

---

### Get Single Threat Event

```http
GET /api/threat-events/{id}
```

Missing records return:

```http
404 Not Found
```

---

### Create Threat Event

Authentication required.

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

Successful response:

```http
201 Created
```

Unauthenticated requests return:

```http
401 Unauthorized
```

Invalid requests return:

```http
422 Unprocessable Entity
```

---

### Update Threat Event

Authentication required.

```http
PATCH /api/threat-events/{id}
```

Partial updates are supported.

Example:

```json
{
  "severity": "critical",
  "threat_type": "DDoS"
}
```

---

### Delete Threat Event

Authentication required.

```http
DELETE /api/threat-events/{id}
```

Missing records return:

```http
404 Not Found
```

---

## API Endpoint Summary

```text
GET     /api/health
GET     /api/threat-events
GET     /api/threat-events/{id}
POST    /api/threat-events
PATCH   /api/threat-events/{id}
DELETE  /api/threat-events/{id}
```

Public endpoints:

```text
GET /api/health
GET /api/threat-events
GET /api/threat-events/{id}
```

Sanctum-protected endpoints:

```text
POST   /api/threat-events
PATCH  /api/threat-events/{id}
DELETE /api/threat-events/{id}
```

Detailed API documentation:

```text
docs/api.md
```

OpenAPI specification:

```text
docs/openapi.yaml
```

---

## API Security

Read operations remain publicly accessible.

Write operations are protected using Laravel Sanctum:

```text
POST
PATCH
DELETE
```

Protected routes use Laravel's:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/threat-events', [ThreatEventController::class, 'store']);
    Route::patch('/threat-events/{threatEvent}', [ThreatEventController::class, 'update']);
    Route::delete('/threat-events/{threatEvent}', [ThreatEventController::class, 'destroy']);
});
```

Unauthenticated write requests receive:

```http
401 Unauthorized
```

This keeps telemetry readable while preventing unauthorized modification.

---

## API Validation

Incoming create and update requests are validated using dedicated Laravel Form Request classes.

### Create Validation

```text
source_ip        required, valid IP address
destination_ip   required, valid IP address
threat_type      required, string, max 255
severity         required, low|medium|high|critical
location         optional, string, max 100
payload_details  optional, string
```

### Update Validation

Updates support partial request bodies.

```text
source_ip        valid IP address
destination_ip   valid IP address
threat_type      string, max 255
severity         low|medium|high|critical
location         optional string, max 100
payload_details  optional string
```

Invalid API input receives:

```http
422 Unprocessable Entity
```

---

## OpenAPI

The repository includes an OpenAPI 3.0 specification describing the REST API.

File:

```text
docs/openapi.yaml
```

The specification documents:

- Health endpoint
- Threat-event listing
- Query filters
- Threat-event retrieval
- Threat-event creation
- Threat-event updates
- Threat-event deletion
- Bearer-token authentication
- Request schemas
- Response schemas
- HTTP status codes

It can be imported into tools such as:

- Swagger Editor
- Swagger UI
- Postman
- Insomnia
- Stoplight

---

## Automated Testing

The application uses PHPUnit and Laravel's testing utilities.

Current test suite:

```text
17 tests
82 assertions
```

Coverage includes:

- Application availability
- Health endpoint
- Dashboard threat-event loading
- Paginated threat-event listing
- Filtering by severity
- Filtering by threat type
- Filtering by source IP
- Single threat-event retrieval
- Missing event handling
- Unauthorized write protection
- Authenticated threat-event creation
- Create-request validation
- Authenticated threat-event updates
- Update-request validation
- Authenticated threat-event deletion
- Missing delete target handling

Run the full test suite:

```bash
php artisan test
```

Current result:

```text
Tests: 17 passed (82 assertions)
```

The test suite uses Laravel's `RefreshDatabase` functionality to isolate database state between feature tests.

---

## Continuous Integration

GitHub Actions validates the project automatically on:

```text
Pushes to main
Pull requests
```

The CI pipeline performs:

```text
Repository checkout
PHP 8.4 environment setup
Node.js environment setup
Composer dependency installation
NPM dependency installation
Laravel environment configuration
Frontend production build
Automated PHPUnit tests
```

Workflow:

```text
.github/workflows/tests.yml
```

The project uses PHP 8.4 because its installed Symfony dependencies require PHP 8.4.1 or newer.

---

## Tech Stack

### Backend

- PHP 8.4+
- Laravel 13
- Laravel Sanctum
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
- Leaflet

### Data & Testing

- SQLite
- Eloquent factories
- Laravel `RefreshDatabase`
- PHPUnit feature tests

### DevOps & Tooling

- Docker
- GitHub Actions
- OpenAPI 3
- Composer
- NPM
- Git
- Laravel Pint
- Laravel Pail

---

## Architecture

### API Flow

```text
Client
  |
  v
Laravel Routes
  |
  +---- Public GET Endpoints
  |
  +---- Sanctum-Protected Write Endpoints
  |
  v
Form Request Validation
  |
  v
ThreatEventController
  |
  v
ThreatEvent Model
  |
  v
SQLite Database
  |
  v
JSON Response
```

### Protected Write Flow

```text
HTTP Request
    |
    v
auth:sanctum
    |
    +---- unauthenticated ----> 401
    |
    v
Form Request Validation
    |
    +---- invalid ------------> 422
    |
    v
Controller
    |
    v
Eloquent ORM
    |
    v
Database
    |
    v
JSON Response
```

### Real-Time Flow

```text
telemetry:stream
      |
      v
ThreatEvent
      |
      v
ThreatDetected Event
      |
      v
Laravel Broadcasting
      |
      v
Laravel Reverb
      |
      v
Laravel Echo
      |
      v
Alpine.js Dashboard
      |
      +---- Live Feed
      +---- Severity Metrics
      +---- Threat Score
      +---- Attack Map
```

---

## Project Structure

```text
app/
├── Console/
│   └── Commands/
│       └── StreamThreatTelemetry.php
├── Events/
│   └── ThreatDetected.php
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── ThreatEventController.php
│   │   └── DashboardController.php
│   └── Requests/
│       ├── StoreThreatEventRequest.php
│       └── UpdateThreatEventRequest.php
├── Models/
│   ├── ThreatEvent.php
│   └── User.php
│
config/
├── broadcasting.php
├── reverb.php
└── sanctum.php
│
database/
├── factories/
│   └── ThreatEventFactory.php
├── migrations/
└── seeders/
    └── DatabaseSeeder.php
│
docs/
├── api.md
└── openapi.yaml
│
resources/
├── js/
│   ├── app.js
│   └── echo.js
└── views/
    └── dashboard.blade.php
│
routes/
├── api.php
├── channels.php
└── web.php
│
tests/
├── Feature/
└── Unit/
│
.github/
└── workflows/
    └── tests.yml

Dockerfile
.dockerignore
```

---

# Local Development

## 1. Clone the Repository

```bash
git clone https://github.com/zakaria-mokri/threat-telemetry-soc.git
cd threat-telemetry-soc
```

---

## 2. Install PHP Dependencies

```bash
composer install
```

---

## 3. Install Frontend Dependencies

```bash
npm install
```

---

## 4. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

---

## 5. Configure SQLite

Create the SQLite database:

```bash
touch database/database.sqlite
```

Ensure the environment uses SQLite:

```env
DB_CONNECTION=sqlite
```

---

## 6. Run Migrations

```bash
php artisan migrate
```

This creates the application tables, including Sanctum's personal access token table.

---

## 7. Build Frontend Assets

For a production-style build:

```bash
npm run build
```

For frontend development:

```bash
npm run dev
```

---

## 8. Start the Real-Time SOC Dashboard

The full real-time dashboard requires **three concurrent processes**:

```text
Laravel application server
Laravel Reverb WebSocket server
Threat telemetry simulator
```

Open three terminal windows in the project directory.

### Terminal 1 — Laravel Application

```bash
php artisan serve
```

### Terminal 2 — Laravel Reverb

```bash
php artisan reverb:start
```

### Terminal 3 — Threat Telemetry Stream

```bash
php artisan telemetry:stream --interval=2
```

Then open:

```text
http://127.0.0.1:8000
```

The telemetry simulator generates a new simulated security event every two seconds.

Each generated threat event is:

- persisted to SQLite
- broadcast through Laravel Reverb
- received by Laravel Echo
- added to the live telemetry feed
- reflected in dashboard severity statistics
- included in the threat score
- plotted on the global attack map

All three processes must remain running to reproduce the full real-time SOC dashboard.

Stop a process with:

```text
Ctrl + C
```

---

## Running Tests

```bash
php artisan test
```

Expected project result:

```text
17 passed
82 assertions
```

---

## Generate Sample Threat Events

The `ThreatEventFactory` can generate database records for testing.

Open Laravel Tinker:

```bash
php artisan tinker
```

Then run:

```php
App\Models\ThreatEvent::factory()->count(20)->create();
```

Generated data includes:

- IPv4 addresses
- Threat types
- Severity levels
- Country codes
- Payload descriptions

---

## Docker

The repository includes a Docker configuration for running the Laravel application and API.

### Build the Image

```bash
docker build -t threat-telemetry-soc .
```

### Run the Container

```bash
docker run --rm -p 8000:8000 threat-telemetry-soc
```

The application becomes available at:

```text
http://127.0.0.1:8000
```

Verify the API:

```bash
curl http://127.0.0.1:8000/api/health
```

Expected response:

```json
{
  "status": "ok",
  "service": "threat-telemetry-soc"
}
```

> The standard Docker startup runs the Laravel web application. The complete real-time dashboard additionally requires Laravel Reverb and the telemetry stream process described in the Local Development section.

---

## Development Status

### Completed

- Threat-event database model
- Threat-event factory
- SOC dashboard
- Real-time telemetry simulator
- Laravel Reverb broadcasting
- Laravel Echo client integration
- Live telemetry feed
- Live threat-map visualization
- Health-check endpoint
- Full CRUD REST API
- Paginated API responses
- Single-event retrieval
- Threat-event filtering
- Form Request validation
- Laravel Sanctum integration
- Protected write endpoints
- Authentication regression testing
- PHPUnit feature tests
- 17 passing automated tests
- 82 assertions
- GitHub Actions CI
- Production frontend build verification
- Docker image
- API documentation
- OpenAPI 3 specification
- Meaningful incremental Git history

### Optional Future Improvements

- Role-based authorization
- Additional security-focused edge-case tests
- Persistent managed production database
- Interactive hosted Swagger UI
- Rate limiting
- Additional telemetry analytics
- Production WebSocket infrastructure

---

## Engineering Practices Demonstrated

This project emphasizes maintainable engineering practices rather than feature implementation alone.

It demonstrates:

- RESTful API design
- Authentication middleware
- Explicit request validation
- Eloquent model factories
- Automated regression testing
- Isolated test databases
- Continuous integration
- Containerized environments
- Reproducible builds
- OpenAPI documentation
- WebSocket broadcasting
- Environment-based configuration
- Incremental Git commits
- Separation of public and protected API operations

---

## Portfolio Highlights

This project demonstrates an end-to-end software engineering workflow:

```text
Application Development
        +
REST API Design
        +
Validation
        +
Authentication
        +
Automated Testing
        +
Continuous Integration
        +
Docker
        +
OpenAPI Documentation
        +
Real-Time WebSockets
```

The project is tested, containerized, documented, continuously validated, and includes a reproducible real-time SOC telemetry environment using Laravel Reverb.

---

## License

This project is intended for educational and portfolio purposes.