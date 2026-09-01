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
  <img src="https://img.shields.io/badge/Render-Live-46E3B7?style=flat&logo=render&logoColor=black" alt="Render">
  <img src="https://img.shields.io/badge/Reverb-WebSockets-4A154B?style=flat&logo=laravel&logoColor=white" alt="Laravel Reverb">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=flat&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
</p>

# Threat Telemetry SOC

![Tests](https://github.com/zakaria-mokri/threat-telemetry-soc/actions/workflows/tests.yml/badge.svg)

A Laravel-based Security Operations Center dashboard and REST API for collecting, storing, filtering, managing, and visualizing simulated threat telemetry.

The project demonstrates backend engineering, API security, automated testing, continuous integration, Docker containerization, OpenAPI documentation, real-time application architecture, and production deployment.

---

## Live Demo

**Application**

https://threat-telemetry-soc.onrender.com

**API Health**

https://threat-telemetry-soc.onrender.com/api/health

> The public demo runs on Render's free tier. After a period of inactivity, the service may need a short time to wake up on the first request.

---

## Overview

Threat Telemetry SOC simulates a lightweight Security Operations Center environment.

Security events such as brute-force attempts, SQL injection attempts, DDoS activity, XSS attacks, and port scans can be persisted in the database, queried through a REST API, filtered by security attributes, and displayed through a monitoring dashboard.

The project currently includes:

- Persistent threat-event storage
- SOC monitoring dashboard
- Full CRUD REST API
- Laravel Sanctum API protection
- Public read endpoints
- Protected write endpoints
- Request validation with Laravel Form Requests
- Threat-event filtering
- API pagination
- Automated PHPUnit feature tests
- API health monitoring
- Laravel Reverb real-time communication tooling
- GitHub Actions continuous integration
- Dockerized application environment
- OpenAPI 3 specification
- Dedicated API reference
- Public Render deployment

---

## Screenshots

### SOC Dashboard

![Threat Telemetry SOC Dashboard](public/assets/images/dashboard-map.jpg)

### Live Telemetry

![Live Threat Telemetry](https://github.com/user-attachments/assets/36386113-d97d-4495-b8da-bb8fcd5f5f83)

---

## Key Features

### Threat Event Management

Threat events contain:

- Source IP address
- Destination IP address
- Threat type
- Severity
- Geographic location
- Payload details
- Creation timestamp
- Update timestamp

Supported severity levels:

```text
low
medium
high
critical
```

Example threat types:

```text
SSH Brute Force
SQL Injection
DDoS
XSS
Port Scan
```

---

### API Security

Read operations remain publicly accessible.

Write operations are protected with Laravel Sanctum:

```text
POST
PATCH
DELETE
```

Unauthenticated write requests receive:

```http
401 Unauthorized
```

This allows public access to telemetry while preventing unauthorized modification of stored threat events.

---

### Filtering

Threat events can be filtered by:

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

Filtering works together with the paginated API response.

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

Optional filters:

```text
severity
threat_type
source_ip
```

Example:

```http
GET /api/threat-events?severity=critical
```

---

### Get Single Threat Event

```http
GET /api/threat-events/{id}
```

Returns one threat event.

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

Example:

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

Invalid input returns:

```http
422 Unprocessable Entity
```

Unauthenticated requests return:

```http
401 Unauthorized
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

Successful response:

```json
{
  "message": "Threat event updated successfully.",
  "data": {
    "severity": "critical",
    "threat_type": "DDoS"
  }
}
```

---

### Delete Threat Event

Authentication required.

```http
DELETE /api/threat-events/{id}
```

Successful response:

```json
{
  "message": "Threat event deleted successfully."
}
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

Detailed API reference:

```text
docs/api.md
```

OpenAPI specification:

```text
docs/openapi.yaml
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

The specification can be imported into tools such as:

- Swagger Editor
- Swagger UI
- Postman
- Insomnia
- Stoplight

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

Invalid API input receives structured JSON validation errors:

```http
422 Unprocessable Entity
```

---

## Authentication

Laravel Sanctum provides API authentication for write operations.

The `User` model uses:

```php
use Laravel\Sanctum\HasApiTokens;
```

Protected routes use:

```php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/threat-events', [ThreatEventController::class, 'store']);
    Route::patch('/threat-events/{threatEvent}', [ThreatEventController::class, 'update']);
    Route::delete('/threat-events/{threatEvent}', [ThreatEventController::class, 'destroy']);
});
```

This prevents unauthenticated clients from creating, modifying, or deleting threat telemetry.

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

GitHub Actions automatically validates the project on:

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

The workflow uses PHP 8.4 because the installed Symfony 8 dependencies require PHP 8.4.1 or newer.

---

## Docker

The application includes a tested Docker configuration.

Docker support includes:

```text
PHP 8.4
Composer
Node.js
NPM
SQLite PHP extensions
Laravel dependencies
Frontend production build
Laravel application server
Automatic production migrations
Dynamic hosting port support
```

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

Verify the containerized API:

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

The Docker image has been successfully built and verified using a running container.

---

## Deployment

The application is deployed publicly on Render using the repository's Docker configuration.

Live application:

```text
https://threat-telemetry-soc.onrender.com
```

Health endpoint:

```text
https://threat-telemetry-soc.onrender.com/api/health
```

The production container:

1. Starts from PHP 8.4
2. Installs Composer and frontend dependencies
3. Builds production frontend assets
4. Creates the SQLite database if required
5. Runs Laravel migrations with `--force`
6. Starts Laravel on the hosting platform's dynamic `$PORT`

The application is configured with production environment variables such as:

```text
APP_ENV=production
APP_DEBUG=false
LOG_CHANNEL=stderr
DB_CONNECTION=sqlite
```

Sensitive values such as `APP_KEY` are configured through Render environment variables and are not committed to the repository.

> Render's free tier may spin the service down after inactivity. The first request after inactivity can therefore take longer than normal.

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

### Data & Testing

- SQLite
- Eloquent factories
- Laravel `RefreshDatabase`
- PHPUnit feature tests

### DevOps & Tooling

- Docker
- GitHub Actions
- Render
- OpenAPI 3
- Composer
- NPM
- Git
- Laravel Pint
- Laravel Pail

---

## Architecture

Simplified application flow:

```text
Client
  |
  v
Laravel Routes
  |
  +---- Public GET Endpoints
  |
  +---- Sanctum Protected Write Endpoints
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
Database
  |
  v
JSON Response
```

Protected write flow:

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

Deployment flow:

```text
GitHub Repository
       |
       v
GitHub Actions CI
       |
       v
Render
       |
       v
Docker Build
       |
       v
Laravel Migrations
       |
       v
Laravel Application
       |
       v
Public HTTPS URL
```

---

## Project Structure

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
└── Models/
    ├── ThreatEvent.php
    └── User.php

config/
└── sanctum.php

database/
├── factories/
│   └── ThreatEventFactory.php
└── migrations/
    ├── create_threat_events_table.php
    └── create_personal_access_tokens_table.php

docs/
├── api.md
└── openapi.yaml

routes/
├── api.php
├── web.php
└── channels.php

tests/
├── Feature/
│   ├── ExampleTest.php
│   ├── HealthApiTest.php
│   └── ThreatEventTest.php
└── Unit/

.github/
└── workflows/
    └── tests.yml

Dockerfile
.dockerignore
```

---

## Local Development

### 1. Clone the Repository

```bash
git clone https://github.com/zakaria-mokri/threat-telemetry-soc.git
cd threat-telemetry-soc
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Frontend Dependencies

```bash
npm install
```

### 4. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configure SQLite

```bash
touch database/database.sqlite
```

Set:

```env
DB_CONNECTION=sqlite
```

### 6. Run Migrations

```bash
php artisan migrate
```

This creates the application tables, including Sanctum's personal access token table.

### 7. Build Frontend

```bash
npm run build
```

For frontend development:

```bash
npm run dev
```

### 8. Start Laravel

```bash
php artisan serve
```

Application:

```text
http://127.0.0.1:8000
```

---

## Running Tests

```bash
php artisan test
```

Current result:

```text
17 passed
82 assertions
```

---

## Generate Sample Threat Events

The `ThreatEventFactory` generates realistic test data including:

```text
IPv4 addresses
Threat types
Severity levels
Country codes
Payload descriptions
```

Open Laravel Tinker:

```bash
php artisan tinker
```

Generate sample events:

```php
App\Models\ThreatEvent::factory()->count(20)->create();
```

---

## Development Status

### Completed

- Threat-event database model
- Threat-event factory
- SOC dashboard
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
- Docker runtime verification
- Render-compatible Docker startup
- API documentation
- OpenAPI 3 specification
- Public Render deployment
- Live health endpoint
- Meaningful incremental Git history

### Optional Future Improvements

- Role-based authorization
- Additional security-focused edge-case tests
- Persistent managed production database
- Interactive hosted Swagger UI
- Rate limiting
- Additional telemetry analytics

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
- Production deployment
- Environment-based configuration
- Incremental Git commits
- Clear separation of public and protected API operations

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
Cloud Deployment
```

Rather than being only a local prototype, the application is tested, containerized, documented, continuously validated, and publicly deployed.

---

## License

This project is intended for educational and portfolio purposes.