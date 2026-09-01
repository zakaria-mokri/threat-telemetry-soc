# Threat Telemetry SOC API

Base path:

```text
/api
```

## Health Check

### GET `/api/health`

Returns the current API health status.

Example response:

```json
{
  "status": "ok",
  "service": "threat-telemetry-soc"
}
```

---

## List Threat Events

### GET `/api/threat-events`

Returns paginated threat events.

Example response structure:

```json
{
  "data": [],
  "current_page": 1,
  "last_page": 1,
  "per_page": 20,
  "total": 0
}
```

### Filtering

The threat-event list endpoint supports optional query parameters.

Filter by severity:

```http
GET /api/threat-events?severity=critical
```

Filter by threat type:

```http
GET /api/threat-events?threat_type=SSH
```

Filter by source IP:

```http
GET /api/threat-events?source_ip=203.0.113.50
```

Filters can be combined with pagination.

---

## Get Threat Event

### GET `/api/threat-events/{id}`

Returns one threat event.

Example response:

```json
{
  "data": {
    "id": 1,
    "source_ip": "203.0.113.10",
    "destination_ip": "198.51.100.5",
    "threat_type": "Port Scan",
    "severity": "medium",
    "location": "DE",
    "payload_details": "Suspicious network activity detected.",
    "created_at": "2026-09-01T18:00:00.000000Z",
    "updated_at": "2026-09-01T18:00:00.000000Z"
  }
}
```

If the event does not exist:

```text
404 Not Found
```

---

## Create Threat Event

### POST `/api/threat-events`

Request body:

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

```text
201 Created
```

Example response:

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

Validation rules:

```text
source_ip        required, valid IP
destination_ip   required, valid IP
threat_type      required, string, max 255
severity         required, low|medium|high|critical
location         optional, string, max 100
payload_details  optional, string
```

Invalid input returns:

```text
422 Unprocessable Entity
```

---

## Update Threat Event

### PATCH `/api/threat-events/{id}`

Partially updates an existing threat event.

Example request:

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
    "id": 1,
    "source_ip": "203.0.113.10",
    "destination_ip": "198.51.100.5",
    "threat_type": "DDoS",
    "severity": "critical",
    "location": "DE",
    "payload_details": "Suspicious network activity detected."
  }
}
```

Invalid input returns:

```text
422 Unprocessable Entity
```

If the event does not exist:

```text
404 Not Found
```

---

## Delete Threat Event

### DELETE `/api/threat-events/{id}`

Deletes an existing threat event.

Successful response:

```json
{
  "message": "Threat event deleted successfully."
}
```

If the event does not exist:

```text
404 Not Found
```

---

## Validation

### Create Request

```text
source_ip        required, valid IP address
destination_ip   required, valid IP address
threat_type      required, string, max 255 characters
severity         required, low|medium|high|critical
location         optional, string, max 100 characters
payload_details  optional, string
```

### Update Request

Updates support partial request bodies.

```text
source_ip        valid IP address
destination_ip   valid IP address
threat_type      string, max 255 characters
severity         low|medium|high|critical
location         optional string, max 100 characters
payload_details  optional string
```

---

## HTTP Response Codes

```text
200 OK
201 Created
404 Not Found
422 Unprocessable Entity
500 Internal Server Error
```

---

## Example cURL Requests

### Health Check

```bash
curl http://127.0.0.1:8000/api/health
```

### List Threat Events

```bash
curl http://127.0.0.1:8000/api/threat-events
```

### Filter by Severity

```bash
curl "http://127.0.0.1:8000/api/threat-events?severity=critical"
```

### Filter by Threat Type

```bash
curl "http://127.0.0.1:8000/api/threat-events?threat_type=SSH"
```

### Filter by Source IP

```bash
curl "http://127.0.0.1:8000/api/threat-events?source_ip=203.0.113.50"
```

### Get Threat Event

```bash
curl http://127.0.0.1:8000/api/threat-events/1
```

### Create Threat Event

```bash
curl -X POST http://127.0.0.1:8000/api/threat-events \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "source_ip": "192.168.1.10",
    "destination_ip": "10.0.0.5",
    "threat_type": "SSH Brute Force",
    "severity": "high",
    "location": "DE",
    "payload_details": "Multiple failed login attempts detected."
  }'
```

### Update Threat Event

```bash
curl -X PATCH http://127.0.0.1:8000/api/threat-events/1 \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "severity": "critical",
    "threat_type": "DDoS"
  }'
```

### Delete Threat Event

```bash
curl -X DELETE http://127.0.0.1:8000/api/threat-events/1 \
  -H "Accept: application/json"
```

---

## Current API Coverage

```text
GET     /api/health
GET     /api/threat-events
GET     /api/threat-events/{id}
POST    /api/threat-events
PATCH   /api/threat-events/{id}
DELETE  /api/threat-events/{id}
```

Supported filters:

```text
severity
threat_type
source_ip
```

Automated tests currently cover:

```text
Health endpoint
Paginated threat-event listing
Filtering by severity
Filtering by threat type
Filtering by source IP
Single threat-event retrieval
404 handling
Threat-event creation
Create validation
Threat-event updates
Update validation
Threat-event deletion
Delete 404 handling
```